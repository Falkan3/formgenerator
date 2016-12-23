<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function questions()
    {
        return $this->hasMany('App\Question', 'survey_id');
    }

    public function answers()
    {
        return $this->hasMany('App\SurveyResult', 'survey_id');
    }
}
