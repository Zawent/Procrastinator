<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Respuesta extends Model
{
    use HasFactory;

    protected $fillable = ["respuesta"];
    public $timestamps = false;

    public function users (){
        return $this->hasOne(User::class, 'id_usuario','nombre');
    }
    public function nivel() { 
        return $this->hasOne(Nivel::class, 'id_nivel','nombre');
    }
    public function pregunta(){
        return $this->belongsto(Pregunta::class, 'id_pregunta');
    }

    }

