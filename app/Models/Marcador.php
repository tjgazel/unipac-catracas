<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Marcador extends Model
{
    protected $table = 'marcadores';

    public $timestamps = false;

    protected $fillable = ['nome', 'classe', 'intervalos', 'aula_normal', 'repor'];

    public function calendarios()
    {
        return $this->hasMany(Calendario::class);
    }
}
