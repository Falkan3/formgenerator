<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $casts = [
        'values' => 'array',
    ];

    public function survey() {
        return $this->belongsTo('App\Survey', 'survey_id');
    }
}
