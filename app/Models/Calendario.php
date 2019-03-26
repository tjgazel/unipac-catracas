<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Calendario extends Model
{
    public $timestamps = false;

    protected $dates = ['data_inicio', 'data_termino'];

    protected $fillable = ['identificacao', 'data_inicio', 'data_termino'];

    public function dados()
    {
        return $this->hasMany(DadosCalendario::class);
    }
}
