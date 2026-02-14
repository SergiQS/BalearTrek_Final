<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Trek;
use App\Models\PlaceType;

class InterestingPlace extends Model
{
    //
    protected $fillable = [
        'name',
        'gps',
        'place_type_id'
    ];

    public function treks() {
        return $this->belongsToMany(Trek::class);//un lugar de interes puede pertenecer a muchos treks
    }
    public function placeType() {
        return $this->belongsTo(PlaceType::class);//un lugar de interes pertenece a un tipo de lugar
    }
}
