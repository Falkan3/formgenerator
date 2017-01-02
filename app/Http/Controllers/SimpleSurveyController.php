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
    public function checkIfDone($id)
    {
        $cookie = Cookie::get(config('app.cookie_prefix') . 'guest_id');
        if (isset($cookie))
            $cookie_val = $cookie;
        else
            $cookie_val = '';

        $result = SurveyResult::where('cookie', $cookie_val)->first();//where('ip', request()->ip())->first();
        $lastStep = Question::where('survey_id', $id)->max('step');

        if (isset($result)) {
            $saved_step = SurveyResult::where('cookie', $cookie_val)->max('survey_step'); //where('ip', request()->ip())
            if ($saved_step == $lastStep) {
                return true;
            }
        }

        return false;
    }

    public function getSurvey($id, $step = null, $cookie_val = null)
    {
        if (is_null($cookie_val)) {
            $cookie = Cookie::get(config('app.cookie_prefix') . 'guest_id');
            if (isset($cookie))
                $cookie_val = $cookie;
            else
                $cookie_val = '';
        }

        $result = SurveyResult::where('cookie', $cookie_val)->first();//where('ip', request()->ip())->first();
        $lastStep = Question::where('survey_id', $id)->max('step');

        if (isset($result)) {
            $saved_step = SurveyResult::where('cookie', $cookie_val)->max('survey_step');

            if (is_null($step) || $step > $lastStep)
                $data = $this->getSurveyStep($id, $saved_step + 1);
            else
                $data = $this->getSurveyStep($id, $step);
        } else
            $data = $this->getSurveyStep($id, 1);

        $data['last_step'] = $lastStep;

        return $data;
    }

    public function getSurveyStep($id, $step)
    {
        $questions = $this->fetchStepQuestions($id, $step);
        if (empty($questions)) {
            abort(404);
        }

        $step_title_raw = Survey::find($id);
        $step_title = json_decode($step_title_raw->step_titles, 1)[$step];

        return ['id' => $id, 'survey_step_title' => $step_title, 'questions' => $questions, 'step' => $step];
    }

    protected function fetchStepQuestions($id, $step)
    {
        $questions = Question::where('survey_id', $id)->where('step', $step)->get();
        if (empty($questions)) {
            abort(404);
        }

        return $questions;
    }

    public function postSurveyStep($id, $step, Request $request, CookieJar $cookieJar)
    {
        $questions = $this->fetchStepQuestions($id, $step);
        $lastStep = Question::where('survey_id', $id)->max('step');

        $rules = [];
        foreach ($questions as $question) {
            $rules[$question->name] = $question->rule;
        }

        //$this->validate($request, $rules);

        $cookie = Cookie::get(config('app.cookie_prefix') . 'guest_id');
        if (isset($cookie))
            $cookie_val = $cookie;
        else
            $cookie_val = '';

        //
        try
        {
            $this->validate($request, $rules);
        }
        catch(\Exception $ex)
        {
            return redirect('/')->withCookie($cookie);
        }
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

                //return redirect('survey/done/'.$id)->withCookie($cookie);
                return app('App\Http\Controllers\MainController')->index($this->getSurvey($id, $step + 2, $cookie_val))->withCookie($cookie);
            }
        }

        //$page = Page::findOrFail(1);
        if ($step + 1 > $lastStep) {
            return redirect('survey/done/' . $id)->withCookie($cookie);
        } else {
            //return redirect('/')->withCookie($cookie);
            return app('App\Http\Controllers\MainController')->index($this->getSurvey($id, $step + 1, $cookie_val))->withCookie($cookie);
            //return view('pages.main', ['layout' => $page->getLayout->location, 'survey' => $this->getSurvey($id, $step+1)]);
        }
    }

    public function getSurveyDone($id)
    {
        if ($this->checkIfDone($id)) {
            $page = Page::findOrFail(1);
            return view('pages.alreadydone', ['layout' => $page->getLayout->location]);
        } else {
            return redirect('/');
        }
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
            $saved_step = SurveyResult::where('cookie', $cookie_val)->max('survey_step');
            if ($saved_step > 0 && $step - 1 > 0) {
                $data = $this->getSurveyStep($id, $step - 1);
                $answers = SurveyResult::where('cookie', $cookie_val)->where('survey_step', $step - 1)->first()->answers;
            }
        } else {
            $data = $this->getSurveyStep($id, 1);
        }

        $lastStep = Question::where('survey_id', $id)->max('step');
        $data['last_step'] = $lastStep;

        //$page = Page::findOrFail(1);

        //return view('pages.main', ['layout' => $page->getLayout->location, 'survey' => $data]);
        return app('App\Http\Controllers\MainController')->index($data, $answers);
    }
}
