<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class App extends Model
{
    use HasFactory;

    protected $fillable = ["nombre"];
    public $timestamps = false;

    /**
     * Define la relación con los 
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function bloqueo(): HasMany
    {
        return $this->hasMany(Bloqueo::class, 'id_app');
    }
}
