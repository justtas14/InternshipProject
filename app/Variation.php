<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Variation extends Model
{
    public $timestamps = false;

    public function dishes()
    {
        return $this->belongsToMany('App\Dish');
    }
}
