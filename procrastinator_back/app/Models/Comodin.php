<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comodin extends Model
{
    use HasFactory;
    protected $fillable = ["tiempo_generacion"];
    public $timestamps = false;
    protected $casts = [
        'tiempo_generacion' => 'timestamp',
    ];

    public function bloqueos() {
        return $this->hasMany(Bloqueo::class, 'bloqueo_id');
    }

    public function users(){
        return $this->hasMany(User::class, 'id_user');
    }
}
