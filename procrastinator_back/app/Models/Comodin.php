<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comodin extends Model
{
    use HasFactory;

    protected $fillable = ['tiempo_generacion', 'id_bloqueo', 'user_id'];
    public $timestamps = false;


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
