<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User; // Asegúrate de importar el modelo User si aún no lo has hecho

class Bloqueo extends Model
{
    use HasFactory;
    
    protected $fillable = ["tipo", "duracion", "id_user",]; 

    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
    public function app()
    {
        return $this->hasMany(App::class, 'id_bloqueo', 'nombre');
    }

    public function comodin()
    {
        return $this->hasMany(Comodin::class, 'id_bloqueo');
    }
}
