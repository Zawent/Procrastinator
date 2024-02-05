<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bloqueo extends Model
{
    use HasFactory;

    protected $fillable = ["tipo", "duracion"];
    public $timestamps = false;

    public function apps () {
        return $this->hasMany(App::class, 'bloqueo_id','nombre');
    }

    public function informacion () { 
        return $this->hasMany(Informacion::class, 'bloqueo_id','nombre');
    }
    
}
