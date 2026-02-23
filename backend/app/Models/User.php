<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'lastName',
        'email',
        'dni',
        'phone',
        'password',
        'role_id',
    ];

    protected $guarded = ['id'];

    protected $hidden = [
        'password',
    
    ];
   


     public function setNameAttribute($value)
    {
        $this->attributes['name'] = mb_strtoupper($value, 'UTF-8'); // Convierte el nombre a mayúsculas antes de guardarlo
    }

    public function setLastNameAttribute($value)
    {
        $this->attributes['lastName'] = mb_strtoupper($value, 'UTF-8');// Convierte el apellido a mayúsculas antes de guardarlo
    }

    public function getLastNameAttribute()
    {
        return $this->attributes['lastName'] ?? null; // Devuelve el apellido o null si no está definido
    }
    
    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = mb_strtolower($value, 'UTF-8'); // Convierte el email a minúsculas antes de guardarlo
    }


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
   

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function comments()
    {
        return $this->hasMany(Comment::class); //un usuario puede tener muchos comentarios
    }
    public function role()
    {
        return $this->belongsTo(Role::class); //un usuario pertenece a un rol
    }
    public function meeting()
    {
        return $this->hasMany(Meeting::class); //un guia pertenece a una reunion
    }

    public function meetings()
    {
        return $this->belongsToMany(Meeting::class); //un usuario puede tener muchas reuniones
    }
    
    //verificar si el usuario es admin
    public function isAdmin(): bool
    {
        return $this->role_id === Role::where('name', 'admin')->first()?->id;
    }

}
