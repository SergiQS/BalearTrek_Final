<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Image extends Model
{
    //
    use HasFactory;

        protected $fillable = [
        'url',
        'comment_id',
    ];

    // Relación: una imagen pertenece a un comentario
    public function comment()
    {
        return $this->belongsTo(Comment::class);
    }


    
}
