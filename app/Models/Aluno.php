<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aluno extends Model
{
    protected $connection = 'mysql';

    protected $table = 'catraca_view'; // Dados do aluno

    protected $primaryKey = false;

    public $timestamps = false;

    // credencial, id, nome, fixo, celular, periodo, curso

    public function getCredencial()
    {
        return $this->hasOne(Credencial::class, 'CRED_NUMERO', 'credencial');
    }

    public function getAcessos()
    {
        return $this->hasMany(Acesso::class, 'CRED_NUMERO', 'credencial');
    }

}
