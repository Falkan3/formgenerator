<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Survey;
use App\Question;
use App\SurveyResult;
use App\Page;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Cookie\CookieJar;

class SimpleSurveyController extends Controller
{
    public function getSurvey($id = 1) {
        $cookie = Cookie::get(config('app.cookie_prefix') . 'guest_id');
        $maxStep = Question::where('survey_id', $id)->max('step');
        if (isset($cookie))
        {
            $cookie_val = $cookie;
            $survey = Survey::findOrFail($id);

            $lastSavedStep = SurveyResult::where('survey_id', $id)->where('cookie', $cookie_val)->max('survey_step');
            if(is_null($lastSavedStep))
                $lastSavedStep = 0;
            if($lastSavedStep >= $maxStep)
            {
                return $this->getSurveyDone($id);
            }
            else
            {
                $data = $this->getSurveyStep($id, $lastSavedStep+1, $cookie_val);
            }
        }
        else
        {
            $data = $this->getSurveyStep($id, 1);
        }

        $data['id'] = $id;
        $data['last_step'] = $maxStep;

        return $data;
    }

    public function getSurveyStep($id, $step, $cookie_val = null) {
        //return step, step title, questions
        $questions = $this->getSurveyStepQuestions($id, $step);
        $answers = $this->getAnswers($id, $step, $cookie_val);

        $step_title_raw = Survey::find($id);
        $step_title = json_decode($step_title_raw->step_titles, 1)[$step];

        return ['survey_step_title' => $step_title, 'questions' => $questions, 'step' => $step, 'answers' => $answers];
    }

    public function getSurveyStepQuestions($id, $step) {
        $questions = Question::where('survey_id', $id)->where('step', $step)->get();
        if (empty($questions)) {
            abort(404);
        }

        return $questions;
    }

    public function getAnswers($id, $step, $cookie_val) {
        $answer = SurveyResult::where('survey_id', $id)->where('survey_step', $step)->where('cookie', $cookie_val)->first();
        if(isset($answer))
            $return = $answer->answers;
        else
            $return = null;

        return $return;
    }

    public function generateSurvey($id, $step) {
        if($this->checkIfDone($id) == true)
        {
            return $this->getSurveyDone($id);
        }

        $cookie = Cookie::get(config('app.cookie_prefix') . 'guest_id');
        if (isset($cookie))
        {
            $cookie_val = $cookie;
            /*
            $savedStep = SurveyResult::where('survey_id', $id)->where('cookie', $cookie_val)->where('survey_step', $step)->first();
            if(is_null($savedStep))
                $savedStep = 1;
            */
            if($step==4)
            {
                $result = SurveyResult::where('survey_id', $id)->where('survey_step', 4)->where('cookie', $cookie_val)->first();
                if(isset($result) && $result->answers=='[]')
                    return redirect('survey/gen/'.$id.'/'.($step+1));
            }
            $maxStep = Question::where('survey_id', $id)->max('step');
            $lastSavedStep = SurveyResult::where('survey_id', $id)->where('cookie', $cookie_val)->max('survey_step');
            if($step > $maxStep)
            {
                return redirect('/')->withCookie($cookie);
            }
            else if($step <= $lastSavedStep+1)
            {
                $data = $this->getSurveyStep($id, $step, $cookie_val);
            }
            else
            {
                return redirect('/')->withCookie($cookie);
            }
        }
        else
        {
            return redirect('/');
        }

        $data['id'] = $id;
        $data['last_step'] = $maxStep;

        //-------------------------------------------------------------------------------------
        $page = Page::findOrFail(1);

        if(isset($data['answers']))
            $answers = json_decode($data['answers'], 1);
        else
            $answers = null;

        return view('pages.main', ['layout' => $page->getLayout->location, 'survey' => $data, 'answers' => $answers]);
    }

    public function postSurveyStep($id, $step, Request $request, CookieJar $cookieJar)
    {
        $questions = $this->getSurveyStepQuestions($id, $step);
        $lastStep = Question::where('survey_id', $id)->max('step');

        $rules = [];
        foreach ($questions as $question) {
            $rules[$question->name] = $question->rule;
        }

        $cookie = Cookie::get(config('app.cookie_prefix') . 'guest_id');
        if (isset($cookie))
            $cookie_val = $cookie;
        else
            $cookie_val = '';

        //

        $this->validate($request, $rules);

        //

        $old_result = SurveyResult::where('survey_id', $id)->where('survey_step', $step)->where('cookie', $cookie_val)->first(); //->where('ip', request()->ip())->get();

        if (count($old_result) > 0)
            $result = $old_result;
        else
            $result = new SurveyResult;

        $result->survey_id = $id;
        $result->survey_step = $step;
        $result->answers = json_encode($request->except('_token'));
        $result->ip = request()->ip();

        if (is_null($cookie)) {
            $raw_cookie = uniqid();
            $cookie_val = $raw_cookie;
            $cookie = cookie(config('app.cookie_prefix') . 'guest_id', $cookie_val, 1440);
            $result->cookie = $cookie_val;
        } else {
            $result->cookie = $cookie_val;
        }
        $cookieJar->queue(cookie(config('app.cookie_prefix') . 'guest_id', $cookie_val, 1440));
        $result->save();

        if ($id == 1 && $step == 3) {
            if ($request->pyt11 == 'other') {
                $old_result = SurveyResult::where('survey_id', 1)->where('survey_step', 4)->where('cookie', $cookie_val)->first();
                if (count($old_result) > 0)
                    $result = $old_result;
                else
                    $result = new SurveyResult;

                $result->survey_id = $id;
                $result->survey_step = 4;
                $result->answers = json_encode([]);
                $result->ip = request()->ip();
                if (strlen($cookie) == 0) {
                    $raw_cookie = uniqid();
                    $cookie_val = $raw_cookie;
                    $cookie = cookie(config('app.cookie_prefix') . 'guest_id', $cookie_val, 1440);
                    $result->cookie = $cookie_val;
                } else
                    $result->cookie = $cookie_val;
                $result->save();

                return redirect('survey/gen/'.$id.'/' . ($step+2))->withCookie($cookie);
            }
        }

        //$page = Page::findOrFail(1);
        if ($step + 1 > $lastStep) {
            return $this->getSurveyDone($id);
        } else {
            return redirect('survey/gen/' . $id . '/' . ($step+1))->withCookie($cookie);
        }
    }

    public function getSurveyDone($id = 1)
    {
        $page = Page::findOrFail(1);
        return view('pages.alreadydone', ['layout' => $page->getLayout->location]);
    }

    public function previousStep($id, $step)
    {
        $cookie = Cookie::get(config('app.cookie_prefix') . 'guest_id');
        if (isset($cookie))
            $cookie_val = $cookie;
        else
            $cookie_val = '';

        $result = SurveyResult::where('cookie', $cookie_val)->first();//where('ip', request()->ip())->first();
        //$lastStep = Question::where('survey_id', $id)->max('step');

        if (isset($result)) {
            if($step==5)
            {
                return app('App\Http\Controllers\MainController')->index($this->getSurvey($id, $step, $cookie_val))->withCookie($cookie);
            }
            $saved_step = SurveyResult::where('survey_id', $id)->where('cookie', $cookie_val)->max('survey_step');
            if ($saved_step > 0 && $step - 1 > 0) {
                $data = $this->getSurveyStep($id, $step - 1);
                $answers = SurveyResult::where('cookie', $cookie_val)->where('survey_step', $step - 1)->first()->answers;
            }
        } else {
            return redirect('/');
        }

        $lastStep = Question::where('survey_id', $id)->max('step');
        $data['last_step'] = $lastStep;

        //$page = Page::findOrFail(1);

        //return view('pages.main', ['layout' => $page->getLayout->location, 'survey' => $data]);
        return app('App\Http\Controllers\MainController')->index($data, $answers);
    }

    public function checkIfDone($id) {
        $cookie = Cookie::get(config('app.cookie_prefix') . 'guest_id');
        if (isset($cookie)) {
            $cookie_val = $cookie;
            $lastSavedStep = SurveyResult::where('survey_id', $id)->where('cookie', $cookie_val)->max('survey_step');
            $maxStep = Question::where('survey_id', $id)->max('step');
            if($lastSavedStep >= $maxStep)
            {
                return true;
            }
        }
        return false;
    }
}
