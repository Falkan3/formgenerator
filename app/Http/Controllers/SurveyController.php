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

        //Table of users
        $users_max_step = SurveyResult::selectRaw("`cookie`,max(`survey_step`) as 'max_step'")->groupBy('cookie')->orderBy('max_step', 'desc')->get();
        $names_raw = SurveyResult::select(['cookie', 'answers'])->where('survey_step', 1)->get();
        $users = []; $names = [];
        foreach($users_max_step as $key => $item) {
            $users[$key]['cookie'] = $item['attributes']['cookie'];
            $users[$key]['max_step'] = $item['attributes']['max_step'];
        }
        foreach($users_max_step as $key => $item) {
            $users[$key]['cookie'] = $item['attributes']['cookie'];
            $users[$key]['max_step'] = $item['attributes']['max_step'];
        }
        foreach($names_raw as $key => $item) {
            $names[$key]['cookie'] = $item['attributes']['cookie'];
            $names[$key]['answers'] = json_decode($item['attributes']['answers'],1);
            $names[$key]['imie'] = $names[$key]['answers']['pyt_imie'];
            $names[$key]['email'] = $names[$key]['answers']['pyt_email'];
        }
        foreach($users as $key => $item) {
            foreach($names as $key2 => $item2) {
                if($item['cookie'] === $item2['cookie']) {
                    $users[$key]['imie'] = $item2['imie'];
                    $users[$key]['email'] = $item2['email'];
                }
            }
        }
        //

        $data = ['id' => $id, 'name' => $survey_name, 'steps' => $steps, 'step_titles' => $step_titles, 'created_at' => $survey_date_created, 'users' => $users];

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
        $data = ['id' => $id, 'name' => $survey_name, 'step_title' => $step_titles, 'created_at' => $survey_date_created, 'questions' => $survey_questions, 'answers' => $survey_answers];

        return view('REST.surveys.show', ['data' => $data, 'pagename' => 'Survey results page '.$step]);
    }

    public function showAllResults($id = 1)
    {
        $survey = Survey::findOrFail($id);
        $survey_name = $survey->name;
        $step_titles = json_decode($survey->step_titles, 1);
        $survey_date_created = $survey->created_at;

        $survey_questions_raw = Question::where('survey_id', $id)->get();
        $survey_questions = [];
        foreach($survey_questions_raw as $key => $item) {
            $placeholder = json_decode($item, 1);
            if(is_string($placeholder['values'])) {
                $placeholder['values'] = json_decode($placeholder['values'], 1);
            }
            $survey_questions[$key]['question'] = $placeholder;
            //array_push($survey_questions, json_decode($item, 1));
        }
        $survey_answers_raw = SurveyResult::where('survey_id', $id)->get();
        $survey_answers = [];
        foreach($survey_answers_raw as $item) {
            array_push($survey_answers, json_decode($item->answers, 1));
        }
        foreach($survey_answers as $key => $item) {
            foreach($item as $key2 => $item2) {
                foreach ($survey_questions as $key3 => $item3) {
                    if ($key2 == $item3['question']['name']) {
                        $survey_questions[$key3]['answers']['vals'][] = $item2;
                    }
                    elseif($key2 == 'other_' . $item3['question']['name'] && strlen($item2)>0) {
                        $survey_questions[$key3]['answers']['other'][] = $item2;
                    }
                }
            }
        }

        $data = ['id' => $id, 'name' => $survey_name, 'step_titles' => $step_titles, 'created_at' => $survey_date_created, 'questions' => $survey_questions, 'answers' => $survey_answers];

        return view('REST.surveys.allresults', ['data' => $data, 'pagename' => 'Survey ' . $survey_name . ' all results page']);
    }
}
