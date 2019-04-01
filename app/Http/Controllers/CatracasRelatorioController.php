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
            $response = $http->get('http://unipacto.com.br/calendarios/diascalendario.php', [
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

        if (strlen($form['search']) > 1) {
            $alunos = Aluno::where('nome', 'like', "%{$form['search']}%")->orderBy('nome')->get();
        } else {
            $alunos = Aluno::orderBy('nome')->get();
        }

        $acessos = Acesso::select('CRED_NUMERO', 'MOV_DATAHORA')
            ->whereDate('MOV_DATAHORA', '>=', $form['start']->format('Y-m-d'))
            ->whereDate('MOV_DATAHORA', '<=', $form['end']->format('Y-m-d'))
            ->get();

        $alunos = $alunos->map(function ($aluno) use ($form, $diasLetivos, $acessos) {

            $diasPresentes = 0;


            $acessosAluno = $acessos->filter(function ($acesso) use ($aluno) {
                return $acesso->CRED_NUMERO == $aluno->credencial;
            });

            if ($acessosAluno->count()) {
                $diasAcesso = [];
                foreach ($acessosAluno as $acesso) {
                    if (!in_array($acesso->MOV_DATAHORA->dayOfYear, $diasAcesso)) {
                        $diasAcesso[] = $acesso->MOV_DATAHORA->dayOfYear;
                        $diasPresentes += 1;
                    }
                }
            }

            $aluno->faltas = $diasLetivos - $diasPresentes;

            if ($aluno->faltas > 0) {
                $aluno->faltas_percentual = round($aluno->faltas / $diasLetivos * 100, 2);
            } else {
                $aluno->faltas_percentual = 0;
            }

            if ($aluno->faltas_percentual >= 30) {
                return $aluno;
            }
            return $aluno;
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
