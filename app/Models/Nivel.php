<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nivel extends Model
{
    use HasFactory;

    protected $fillable = ["descripcion"];
    public $timestamps = false;

    public function user () {
        return $this->hasMany(User::class, 'usuario_id' ,'nombre');
    }

    public function respuesta () {
        return $this->hasMany(Respuesta::class, 'nivel_id','id');
    }

    public function informacion () {
        return $this->hasMany(Informacion::class, 'nivel_id','id');
    }

}


