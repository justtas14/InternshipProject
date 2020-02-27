<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dish extends Model
{
    protected $attributes = [
    ];

    public function categories()
    {
        return $this->belongsToMany('App\Category');
    }
    public function variations()
    {
        return $this->belongsToMany('App\Variation');
    }
}
