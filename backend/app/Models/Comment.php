<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{

    protected $fillable = [
    'comment',
    'score',
    'user_id',
    'meeting_id',
];

// public function setScoreAttribute($value)
// {
//     $this->attributes['score'] = max(0, min(5, (int) $value)); //
// }


    public function user() {
        return $this->belongsTo(User::class); //un comentario pertenece a un usuario
    }
    public function meeting() {
        return $this->belongsTo(Meeting::class); //un comentario pertenece a una reunion
    }
    public function images() {
        return $this->hasMany(Image::class);//un comentario puede tener muchas images
    }
}
