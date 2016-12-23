<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Session;
use App\Question;
use Closure;

class SurveyMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $id = $request->id;
        $step = $request->step;

        //$answers = Session::get('survey' . $id . '_step' . $step);
        $max = Question::where('survey_id', $id)->max('step');
        $greatest = Session::get('survey' . $id . 'step')['step'];

        if(is_null($greatest)) {
            $greatest=1;
        }

        if($request->route('step') > $greatest || $request->route('step') > $max)
        {
            //return redirect()->action('SurveyController@getSurveyStep', ['id' => $id, 'step' => $greatest]);
        }

        /*
        if (!$request->survey = Survey::find($request->session()->get('survey_id'))) {
            return redirect()->action('SurveyController@getSurvey');
        }
        $request->maxStep = Question::where('survey_id', $request->session()->get('survey_id'))->max('step');
        if ($request->survey->current_step > $request->maxStep)
        {
            return redirect()->action('SurveyController@getSurveyDone');
        }
        elseif ($request->route('step') > $request->survey->current_step)
        {
            return redirect()->action('SurveyController@getSurveyStep', ['step' => $request->survey->current_step]);
        }
        */
        return $next($request);
    }
}
