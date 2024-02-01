<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class App extends Model
{
    use HasFactory;

    protected $fillable = ["nombre"];
    public $timestamps = false;

    public function bloqueo (){
        return $this->belongsTo(Bloqueo::class, 'app_id','nombre');
    }
    
    public function informacion () {
        return $this->hasMany(Informacion::class, 'app_id','nombre');
    }

}
