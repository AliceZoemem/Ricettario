<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    protected $table='recipes';
    protected $fillable= ['description','totaltime', 'calories', 'difficulty'];
    public function ingredients()
    {
        return $this->belongsToMany('App\Ingredient');
    }
}
