<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Informacion extends Model
{
    use HasFactory;

    protected $fillable = [""];
    public $timestamps = false;

    public function user (){
        return $this->hasOne(User::class, 'id_user','nombre');
    }
    
    public function bloqueos (){
        return $this->hasMany(Bloqueo::class, 'id_bloqueo','nombre');
    }

    public function apps (){
        return $this->hasMany(App::class, 'id_app','nombre');
    }

    public function nivel (){
        return $this->hasOne(Nivel::class, 'id_nivel','nombre');
    }

}
