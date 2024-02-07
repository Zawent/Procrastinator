<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Comodin extends Model
{
    use HasFactory;
    protected $fillable = ['tiempo_generacion','id_bloqueo'];
    public $timestamps = false;
    protected $casts = [
        'tiempo_generacion' => 'datetime',
    ];

    public function bloqueo() {
        return $this->belongsTo(Bloqueo::class, 'id_bloqueo');
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
