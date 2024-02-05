<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Comodin extends Model
{


    use HasFactory;
    public $timestamps = false;

    public function bloqueos() {
        return $this->hasMany(Bloqueo::class, 'duracion');
    }

    public function users(){
        return $this->hasMany(User::class, 'id_user');
    }

    }



