<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dish extends Model
{
    protected $attributes = [
        'is_out_of_stock' => false,
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
