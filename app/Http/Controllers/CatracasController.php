<?php

namespace App\Http\Controllers;

use App\Models\Acesso;
use App\Models\Aluno;
use App\Models\Credencial;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class CatracasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $form = collect([
            'start' => $request->get('start') ? Carbon::createFromTimestamp(strtotime($request->get('start'))) :
                Carbon::now()->addDays(-8),
            'end' => $request->get('end') ? Carbon::createFromTimestamp(strtotime($request->get('end'))) : Carbon::now(),
            'search' => $request->get('search') ?? '',
        ]);


        if (strlen($form['search']) > 0) {
            $credenciais = Credencial::whereDate('CRED_ULTPASSAGEM', '>=', $form['start']->format('Y-m-d'))
                ->whereDate('CRED_ULTPASSAGEM', '<=', $form['end']->format('Y-m-d'))
                ->orderByDesc('CRED_ULTPASSAGEM')
                ->get();

            $alunos = Aluno::where('nome', 'like', "%{$form['search']}%")->get();
            $credenciais_aluno = [];
            foreach ($alunos as $aluno) {
                $credenciais_aluno[] = $aluno->credencial;
            };

            $credenciais = $credenciais->whereIn('CRED_NUMERO', $credenciais_aluno)->filter(function ($credencial){
                return $credencial->getAluno ? true : false;
            });
        } else {
            $credenciais = Credencial::whereDate('CRED_ULTPASSAGEM', '>=', $form['start']->format('Y-m-d'))
                ->whereDate('CRED_ULTPASSAGEM', '<=', $form['end']->format('Y-m-d'))
                ->orderByDesc('CRED_ULTPASSAGEM')
                ->paginate();
        }

        return view('catracas.index', compact(['credenciais', 'form']));
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $start = $request->get('start');
        $end = $request->get('end');
        $form = [
            'start' => $start ?? Carbon::now()->addDays(-8)->format('Y-m-d'),
            'end' => $end ?? Carbon::now()->format('Y-m-d')
        ];

        $acessos = Acesso::where('CRED_NUMERO', $id)
            ->whereDate('MOV_DATAHORA', '>=', $form['start'])
            ->whereDate('MOV_DATAHORA', '<=', $form['end'])
            ->orderByDesc('MOV_DATAHORA')
            ->get();

        return view('catracas.show', compact(['acessos', 'form', 'id']));
    }
}
