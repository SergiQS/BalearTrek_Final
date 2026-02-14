<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Meeting;
use App\Models\Municipality;
class Trek extends Model
{
    //

     protected $fillable = [
       "name",
      "regNumber",
      "municipality_id",
    ];

     public function meetings(){
        return $this->hasMany(Meeting::class);//un trek puede tener muchas lugares de interes
    }
    public function interestingPlaces(){
        return $this->belongsToMany(InterestingPlace::class);//un trek puede tener muchas lugares de interes
    }
    public function municipality() {
        return $this->belongsTo(Municipality::class);//un trek pertenece a un municipio
    }
}
