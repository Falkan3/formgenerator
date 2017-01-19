<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Survey;
use App\Question;
use App\SurveyResult;
use Illuminate\Support\Facades\Session;

class SurveyController extends Controller
{
    public function showSurveySteps($id = 1) {
        $survey = Survey::findOrFail($id);
        $survey_name = $survey->name;
        $steps = Question::where('survey_id', $id)->max('step');
        $step_titles = json_decode($survey->step_titles, 1);
        $survey_date_created = $survey->created_at;

        $data = ['name' => $survey_name, 'steps' => $steps, 'step_titles' => $step_titles, 'created_at' => $survey_date_created];

        return view('REST.surveys.index', ['data' => $data, 'pagename' => 'Survey results pages']);
    }

    public function showSurveyResults($id = 1, $step = 1)
    {
        $survey = Survey::findOrFail($id);
        $survey_name = $survey->name;
        $step_titles = json_decode($survey->step_titles, 1);
        $step_titles = $step_titles[$step];
        $survey_date_created = $survey->created_at;
        $survey_questions_raw = Question::where('survey_id', $id)->where('step', $step)->get();
        $survey_questions = [];
        foreach($survey_questions_raw as $item) {
            array_push($survey_questions, json_decode($item, 1));
        }
        $survey_answers_raw = SurveyResult::where('survey_id', $id)->where('survey_step', $step)->get();
        $survey_answers = [];
        foreach($survey_answers_raw as $item) {
            array_push($survey_answers, json_decode($item->answers, 1));
        }
        $data = ['name' => $survey_name, 'step_title' => $step_titles, 'created_at' => $survey_date_created, 'questions' => $survey_questions, 'answers' => $survey_answers];

        return view('REST.surveys.show', ['data' => $data, 'pagename' => 'Survey results page '.$step]);
    }
}
