<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Layout extends Model
{
    use SoftDeletes;

    public function getPages()
    {
        return $this->hasMany('App\Pages', 'layout');
    }

    protected $dates = ['deleted_at'];
}
