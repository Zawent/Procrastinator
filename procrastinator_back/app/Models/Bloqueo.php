<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bloqueo extends Model
{
    use HasFactory;
    protected $fillable = ["tipo", "duracion"];
    public $timestamps = false;

    public function app () {
        return $this->hasMany(App::class, 'id_bloqueo','nombre');
    }


    public function comodin()
    {
        return $this->hasMany(Comodin::class, 'id_bloqueo');
    }
    
}
