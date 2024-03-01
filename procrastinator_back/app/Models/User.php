<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use App\Models\Bloqueo;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [ 
        'name', 'fecha_nacimiento', 'ocupacion', 'email', 'password', 'id_rol', 'external_id', 'external_auth',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array 
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function nivel(){
        
        return $this->belongsTo(Nivel::class);
    }
    public function comodin()
{
    return $this->hasMany(Comodin::class);

}
public function bloqueo()
    {
        return $this->hasMany(Bloqueo::class, 'id_user');
    }

    public function app(){
        return $this->belongsToMany(App::class);
    }

}
