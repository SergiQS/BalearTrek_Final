<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Zone extends Model
{
    //
    public function municipalities() {
        return $this->hasMany(Municipality::class);//una zona puede tener muchos municipios
    }
}
