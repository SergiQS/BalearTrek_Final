<?php

namespace App\Models;


use Carbon\Carbon;
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
        'dateEnd',
        "location",
        "status",
        "user_id",
        "trek_id",
    ];

    public function setDateIniAttribute($value)
    {
        // Si ya está en formato Y-m-d, no convertir
        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $value)) {
            $this->attributes['dateIni'] = $value;
        } else {
            $this->attributes['dateIni'] = 
                Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
        }
    }

    public function setDateEndAttribute($value)
    {
        if ($value === null || $value === '') {
            $this->attributes['dateEnd'] = null;
            return;
        }
        // Si ya está en formato Y-m-d, no convertir
        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $value)) {
            $this->attributes['dateEnd'] = $value;
        } else {
            $this->attributes['dateEnd'] = 
                Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
        }
    }

    public function setDayAttribute($value)
    {
        // Si ya está en formato Y-m-d, no convertir
        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $value)) {
            $this->attributes['day'] = $value;
        } else {
            $this->attributes['day'] = 
                Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
        }
    }




    public function user()
    {
        return $this->belongsTo(User::class);//guia
    }
    public function users()
    {
        return $this->belongsToMany(User::class);//un usuario puede estar en muchas reuniones
    }
    public function trek()
    {
        return $this->belongsTo(Trek::class);//una reunion pertenece a un trek
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);//una reunion puede tener muchos comentarios
    }
}
