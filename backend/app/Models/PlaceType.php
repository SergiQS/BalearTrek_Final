<?php

namespace App\Models;
use App\Models\InterestingPlace;
use Illuminate\Database\Eloquent\Model;

class PlaceType extends Model
{
    //
    public function places_of_interest() {
        return $this->hasMany(InterestingPlace::class);//un tipo de lugar puede ser  muchos lugares de interes
    }
}
