<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Credencial extends Model
{
    protected $connection = 'sqlsrv';

    protected $table = 'CREDENCIAIS';

    protected $primaryKey = false;

    public $timestamps = false;

    protected $dates = ['CRED_ULTPASSAGEM'];

    public function getCredNumeroAttribute($value)
    {
        return sprintf("%012d", $value);
    }

    public function getAcessos()
    {
        return $this->hasMany(Acesso::class, 'CRED_NUMERO', 'CRED_NUMERO')
            ->orderByDesc('CRAC_ULTPASSAGEM');
    }

    public function getAluno()
    {
        return $this->belongsTo(Aluno::class, 'CRED_NUMERO', 'credencial');
    }
}
