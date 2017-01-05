<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Page;

class MainController extends Controller
{
    public function __construct()
    {
        $this->middleware('web');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page = Page::findOrFail(1);

        if(app('App\Http\Controllers\SimpleSurveyController')->checkIfDone(1)== false)
        {
            $survey = app('App\Http\Controllers\SimpleSurveyController')->getSurvey(1);
            if(isset($survey['answers']))
                $answers = json_decode($survey['answers'], 1);
            else
                $answers = null;

            return view('pages.main', ['layout' => $page->getLayout->location, 'survey' => $survey, 'answers' => $answers]);
        }
        else
        {
            return view('pages.alreadydone', ['layout' => $page->getLayout->location]);
        }
    }

    public function ViewPage($id)
    {
        $page = Page::findOrFail($id);

        return view($page->location, ['layout' => $page->getLayout->location]);
    }
}
