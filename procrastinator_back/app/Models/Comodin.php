<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Comodin extends Model
{
    use HasFactory;
    protected $fillable = ["tiempo_generacion"];
    public $timestamps = false;
    protected $casts = [
        'tiempo_generacion' => 'datetime',
    ];

    public function bloqueos() {
        return $this->belongsTo(Bloqueo::class, 'id_bloqueo');
    }

    public function users(){
        return $this->hasMany(User::class, 'id_user');
    }
}
