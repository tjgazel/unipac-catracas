<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Acesso extends Model
{
    // CRED_NUMERO, CRAC_ULTPASSAGEM
    protected $connection = 'sqlsrv';

    protected $table = 'LOG_CREDENCIAL';

    public $timestamps = false;

    protected $dates = ['MOV_DATAHORA'];

    public function getCredencial()
    {
        return $this->belongsTo(Credencial::class, 'CRED_NUMERO', 'CRED_NUMERO');
    }

    public function getAluno()
    {
        return $this->belongsTo(Aluno::class, 'CRED_NUMERO', 'credencial');
    }
}
