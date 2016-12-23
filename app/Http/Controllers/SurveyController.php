<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Question;
use App\SurveyResult;
use Illuminate\Support\Facades\Session;

class SurveyController extends Controller
{
    public function __construct()
    {
        $this->middleware('survey', ['only' => ['getSurveyStep', 'postSurveyStep']]);
    }

    public function getSurvey($id)
    {
        //$survey = Survey::findOrFail($id);
        $data = $this->getSurveyStep($id, 1);

        return $data;
    }

    public function generateSurvey($id = 1, $step = 1)
    {
        $data = $this->getSurveyStep($id, $step);
        return redirect('/')->with(['data' => $data]);
    }

    protected function fetchStepQuestions($id, $step)
    {
        $questions = Question::where('survey_id', $id)->where('step', $step)->get();
        if (empty($questions)) {
            abort(404);
        }

        return $questions;
    }

    public function getSurveyStep($id, $step)
    {
        $questions = $this->fetchStepQuestions($id, $step);
        $answers = Session::get('survey' . $id . '_step' . $step);

        return ['id' => $id, 'questions' => $questions, 'answers' => $answers, 'step' => $step];
        /*
        return [
            'questions' => $questions,
            'step' => $step,
            'survey' => $request->session()->get('survey')
        ];
        */
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

        /*
        $request->session()->get('survey')
            ->update($request->only(array_keys($rules)))
        ;
        */
        $step_session = collect(['survey_id' => $id, 'step' => $step, 'answers' => $request->except('_token')]);
        $survey = collect(['survey_id' => $id, 'step' => $step]);
        Session::put('survey' . $id . '_step' . $step, $step_session);
        Session::put('survey' . $id . 'step', $survey);

        $result = new SurveyResult;
        $result->survey_id = $id;
        $result->survey_step = $step;
        $result->answers = json_encode($request->except('_token'));
        $result->ip = request()->ip();
        $result->save();

        if ($step == $lastStep) {
            /*
            $finalresults = [];
            for ($i = 0; $i < $lastStep; $i++) {
                $finalresults[] = Session::get('survey' . $id . '_step' . $i);
            }
            //return print_r($finalresults);
            $result = new SurveyResult;
            $result->survey_id = $id;
            $result->survey_step = $step;
            $result->answers = json_encode($finalresults);
            $result->ip = request()->ip();
            $result->save();
            */

            return redirect()->action('SurveyController@getSurveyDone');
        }

        return $this->generateSurvey($id, $step + 1);
    }

    public function getSurveyDone()
    {
        return print_r("Dziękujemy za przesłane dane!");
    }
}
