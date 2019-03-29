<?php

namespace App\Http\Controllers;

use App\Models\Acesso;
use App\Models\Aluno;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class CatracasRelatorioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function index(Request $request)
    {
        $form = collect([
            'start' => $request->get('start') ? Carbon::createFromTimestamp(strtotime($request->get('start'))) :
                Carbon::now()->addDays(-8),
            'end' => $request->get('end') ? Carbon::createFromTimestamp(strtotime($request->get('end'))) : Carbon::now(),
            'search' => $request->get('search') ?? '',
        ]);


        $http = new Client();
        try {
            $response = $http->get('http://www.unipacto.com.br/calendarios/diascalendario.php', [
                'query' => [
                    'i' => $form['start']->format('Y-m-d'),
                    'f' => $form['end']->format('Y-m-d')
                ]
            ]);

            $response = json_decode($response->getBody()->getContents());
        } catch (RequestException $e) {
            throw new \Exception($e->getMessage());
        }

        $diasLetivos = $response->dias;

        if (strlen($form['search']) > 3) {
            $alunos = Aluno::where('nome', 'like', "%{$form['search']}%")->orderBy('nome')->get();
        } else {
            $alunos = Aluno::orderBy('nome')->get();
        }


        $alunos = $alunos->map(function ($aluno, $index) use ($form, $diasLetivos) {

            $diasPresentes = 0;

            if ($aluno->getAcessos->whereBetween('MOV_DATAHORA', [$form['start']->format('Y-m-d'), $form['end']->format('Y-m-d')])->count()) {

                $aluno->acessos = $aluno->getAcessos->whereBetween('MOV_DATAHORA',
                    [$form['start']->format('Y-m-d'), $form['end']->format('Y-m-d')]);

                $diasAcesso = [];
                foreach ($aluno->acessos as $acesso) {
                    if (!in_array($acesso->MOV_DATAHORA->dayOfYear, $diasAcesso)) {
                        $diasAcesso[$acesso->MOV_DATAHORA->year][] = $acesso->MOV_DATAHORA->dayOfYear;
                        $diasPresentes += 1;
                    }
                }
            } else {
                $aluno->acessos = null;
            }

            $aluno->faltas = $diasLetivos - $diasPresentes;

            if ($aluno->faltas > 0) {
                $aluno->faltas_percentual = round($aluno->faltas / $diasLetivos * 100, 2);
            } else {
                $aluno->faltas_percentual = 0;
            }

            if (strlen($form['search']) > 3) {
                return $aluno;
            } elseif ($aluno->faltas_percentual >= 30) {
                return $aluno;
            }
        });

        $alunos = $alunos->sortByDesc('faltas');

        return view('catracas.relatorios.index', compact(['alunos', 'form', 'diasLetivos']));
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $start = $request->get('start');
        $end = $request->get('end');

        $form = [
            'start' => $start ?? Carbon::now()->firstOfMonth()->format('Y-m-d'),
            'end' => $end ?? Carbon::now()->format('Y-m-d')
        ];

        $credAcessos = Acesso::where('CRED_NUMERO', $id)
            ->whereDate('MOV_DATAHORA', '>=', $form['start'])
            ->whereDate('MOV_DATAHORA', '<=', $form['end'])
            ->orderByDesc('MOV_DATAHORA')
            ->get();

        return view('catracas.relatorios.show', compact(['credAcessos', 'form', 'id']));
    }
}
