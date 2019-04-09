<?php

namespace App\Http\Controllers;

use App\Models\Ligacao;
use Illuminate\Http\Request;

class LigacoesController extends Controller
{
    public function index(Request $request)
    {
        $ligacoes = Ligacao::with('user')
            ->where('credencial', $request->get('credencial'))
            ->get();

        return response()->json($ligacoes);
    }

    public function store(Request $request)
    {
        $request->validate([
            'credencial' => 'required',
            'status' => 'required',
            'observacao' => 'max:191'
        ]);

        $data = $request->all();
        $data['user_id'] = auth()->user()->id;
        Ligacao::create($data);

        return response()->json([], 204);
    }
}
