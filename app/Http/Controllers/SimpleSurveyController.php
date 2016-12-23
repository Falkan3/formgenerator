<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Survey;
use App\Question;
use App\SurveyResult;
use App\Page;

class SimpleSurveyController extends Controller
{
    public function checkIfDone($id)
    {
        $result = SurveyResult::where('ip', request()->ip())->first();
        $lastStep = Question::where('survey_id', $id)->max('step');

        if(isset($result))
        {
            $saved_step = SurveyResult::where('ip', request()->ip())->max('survey_step');
            if($saved_step == $lastStep)
            {
                return true;
            }
        }

        return false;
    }

    public function getSurvey($id, $step = 1)
    {
        $result = SurveyResult::where('ip', request()->ip())->first();
        $lastStep = Question::where('survey_id', $id)->max('step');

        if(isset($result))
        {
            $saved_step = SurveyResult::where('ip', request()->ip())->max('survey_step');

            $data = $this->getSurveyStep($id, $saved_step+1);
            return $data;
        }
        else
        {
            $data = $this->getSurveyStep($id, 1);
            return $data;
        }
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

         $old_result = SurveyResult::where('survey_id', $id)->where('survey_step', $step)->where('ip', request()->ip())->get();
         if(count($old_result)>0)
             return redirect('/');

         $result = new SurveyResult;
         $result->survey_id = $id;
         $result->survey_step = $step;
         $result->answers = json_encode($request->except('_token'));
         $result->ip = request()->ip();
         $result->save();

         if($id==1 && $step==3)
         {
             if($request->pyt15=='other')
             {
                 $result = new SurveyResult;
                 $result->survey_id = $id;
                 $result->survey_step = 4;
                 $result->answers = json_encode([]);
                 $result->ip = request()->ip();
                 $result->save();

                 return redirect('survey/done/'.$id);
             }
         }

         //$page = Page::findOrFail(1);
         if ($step+1 > $lastStep) {
             return redirect('survey/done/'.$id);
         }
         else
         {
             return redirect('/');
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
}
