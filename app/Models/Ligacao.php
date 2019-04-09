<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ligacao extends Model
{
    protected $table = 'ligacoes';

    protected $dates = ['created_at', 'updated_at'];

    const statusArray = [
        'A' => 'Atendeu',
        'N' => 'Não atendeu',
        'J' => 'Faltas Justificadas',
        'T' => 'Telefones desatualizados'
    ];

    protected $fillable = ['user_id', 'credencial', 'observacao', 'status', 'created_at', 'updated_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
