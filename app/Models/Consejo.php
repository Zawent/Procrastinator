<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consejo extends Model
{
    use HasFactory;
    protected $fillable = [""];
    public $timestamps = false;

    public function nivel () {
        return $this->hasOne(Nivel::class, 'id_nivel', 'descripcion');
    }
}

