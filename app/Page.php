<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Page extends Model
{
    use SoftDeletes;

    public function getLayout() {
        return $this->belongsTo('App\Layout', 'layout');
    }

    protected $dates = ['deleted_at'];
}
