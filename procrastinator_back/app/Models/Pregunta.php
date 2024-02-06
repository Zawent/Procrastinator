<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pregunta extends Model
{
    use HasFactory;

    protected $fillable = ["descripcion_pregunta"];
    public $timestamps = false;

    public function respuesta () {
        return $this->hasOne(Respuesta::class,'id_respuesta');
    }
}
