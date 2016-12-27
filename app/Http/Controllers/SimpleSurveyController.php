<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Survey;
use App\Question;
use App\SurveyResult;
use App\Page;
use Illuminate\Support\Facades\Cookie;

class SimpleSurveyController extends Controller
{
    public function checkIfDone($id)
    {
        $result = SurveyResult::where('cookie', Cookie::get('guest_id'))->first();//where('ip', request()->ip())->first();
        $lastStep = Question::where('survey_id', $id)->max('step');

        if(isset($result))
        {
            $saved_step = SurveyResult::where('cookie', Cookie::get('guest_id'))->max('survey_step'); //where('ip', request()->ip())
            if($saved_step == $lastStep)
            {
                return true;
            }
        }

        return false;
    }

    public function getSurvey($id, $step = 1)
    {
        $result = SurveyResult::where('cookie', Cookie::get('guest_id'))->first();//where('ip', request()->ip())->first();
        $lastStep = Question::where('survey_id', $id)->max('step');

        if(isset($result))
        {
            $saved_step = SurveyResult::where('cookie', Cookie::get('guest_id'))->max('survey_step');

            if($step > $lastStep)
                $data = $this->getSurveyStep($id, $saved_step+1);
            else
                $data = $this->getSurveyStep($id, $step);
        }
        else
            $data = $this->getSurveyStep($id, 1);

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

        return ['id' => $id, 'survey_step_title' => $step_title,'questions' => $questions, 'step' => $step];
    }

    protected function fetchStepQuestions($id, $step)
    {
        $questions = Question::where('survey_id', $id)->where('step', $step)->get();
        if (empty($questions)) {
            abort(404);
        }

        return $questions;
    }

     public function postSurveyStep($id, $step, Request $request)
     {
         $questions = $this->fetchStepQuestions($id, $step);
         $lastStep = Question::where('survey_id', $id)->max('step');

         $rules = [];
         foreach ($questions as $question) {
             $rules[$question->name] = $question->rule;
         }

         $this->validate($request, $rules);

         $old_result = SurveyResult::where('survey_id', $id)->where('survey_step', $step)->where('cookie', Cookie::get('guest_id'))->first(); //->where('ip', request()->ip())->get();

         if(count($old_result)>0)
             $result = $old_result;
         else
             $result = new SurveyResult;

         $result->survey_id = $id;
         $result->survey_step = $step;
         $result->answers = json_encode($request->except('_token'));
         $result->ip = request()->ip();

         $cookie = Cookie::get('guest_id');

         if(strlen($cookie)==0) {
             $raw_cookie = uniqid();
             $cookie = cookie('guest_id', $raw_cookie, 1440);
             $result->cookie = $raw_cookie;
         }
         else
             $result->cookie = $cookie;
         $result->save();

         if($id==1 && $step==3)
         {
             if($request->pyt15=='other')
             {
                 if(count($old_result)>0)
                     $result = $old_result;
                 else
                     $result = new SurveyResult;

                 $result->survey_id = $id;
                 $result->survey_step = 4;
                 $result->answers = json_encode([]);
                 $result->ip = request()->ip();
                 if(strlen($cookie)==0) {
                     $raw_cookie = uniqid();
                     $cookie = cookie('guest_id', $raw_cookie, 1440);
                     $result->cookie = $raw_cookie;
                 }
                 else
                     $result->cookie = $cookie;
                 $result->save();

                 return redirect('survey/done/'.$id)->withCookie($cookie);
             }
         }

         //$page = Page::findOrFail(1);
         if ($step+1 > $lastStep) {
             return redirect('survey/done/'.$id)->withCookie($cookie);
         }
         else
         {
             //return redirect('/')->withCookie($cookie);
             return app('App\Http\Controllers\MainController')->index($this->getSurvey($id,$step+1))->withCookie($cookie);
             //return view('pages.main', ['layout' => $page->getLayout->location, 'survey' => $this->getSurvey($id, $step+1)]);
         }
     }

     public function getSurveyDone($id)
     {
         if($this->checkIfDone($id))
         {
             $page = Page::findOrFail(1);
             return view('pages.alreadydone', ['layout' => $page->getLayout->location]);
         }
         else
         {
             return redirect ('/');
         }
     }

     public function previousStep($id, $step) {
         $result = SurveyResult::where('cookie', Cookie::get('guest_id'))->first();//where('ip', request()->ip())->first();
         //$lastStep = Question::where('survey_id', $id)->max('step');

         if(isset($result))
         {
             $saved_step = SurveyResult::where('cookie', Cookie::get('guest_id'))->max('survey_step');
             if($saved_step>0 && $step-1 > 0)
             {
                 $data = $this->getSurveyStep($id, $step-1);
                 $answers = SurveyResult::where('cookie', Cookie::get('guest_id'))->where('survey_step', $step-1)->first()->answers;
             }
         }
         else
         {
             $data = $this->getSurveyStep($id, 1);
         }

         //$page = Page::findOrFail(1);

         //return view('pages.main', ['layout' => $page->getLayout->location, 'survey' => $data]);
         return app('App\Http\Controllers\MainController')->index($data, $answers);
     }
}
