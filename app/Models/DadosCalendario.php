<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DadosCalendario extends Model
{
    public $timestamps = false;

    protected $fillable = ['calendario_id', 'marcador_id', 'dia', 'ano', 'dia_sabado_letivo'];

    public function calendario()
    {
        return $this->belongsTo(Calendario::class);
    }

    public function marcador()
    {
        return $this->belongsTo(Marcador::class, 'marcador_id', 'id');
    }
}
