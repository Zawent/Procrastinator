<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comodin extends Model
{
    use HasFactory;

    protected $fillable = ['tiempo_generacion', 'id_bloqueo', 'id_user'];
    public $timestamps = false;

    public function bloqueo()
    {
        return $this->belongsTo(Bloqueo::class, 'id_bloqueo');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
