<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{   
    protected $hidden = [
        'totalScore',
        'countScore',
    ];

    protected $fillable = [
        "day",
        "hour",
        'dateIni',
        "location",
        "status",
        "user_id",
        "trek_id",
    ];



    public function user() {
    return $this->belongsTo(User::class);//guia
}
    public function users() {
        return $this->belongsToMany(User::class);//un usuario puede estar en muchas reuniones
    }
    public function trek() {
        return $this->belongsTo(Trek::class);//una reunion pertenece a un trek
    }
    public function comments() {
        return $this->hasMany(Comment::class);//una reunion puede tener muchos comentarios
    }
}
