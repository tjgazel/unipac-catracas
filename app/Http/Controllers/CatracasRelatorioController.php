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
                Carbon::now()->addDays(-16),
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
            $alunos = Aluno::where('nome', 'like', "%{$form['search']}%")
                ->orderBy('nome')
                ->paginate();
        } else {
            $alunos = Aluno::orderBy('nome')->paginate();
        }

        $alunos->getCollection()->transform(function ($aluno) use ($form, $diasLetivos) {
            $diasPresentes = 0;

            /*$alunoAcesos = $aluno->getAcessos
                ->where('MOV_DATAHORA', '>=', $form['start'])
                ->where('MOV_DATAHORA', '<=', $form['end']);*/

            $alunoAcesos = Acesso::where('CRED_NUMERO', (int) $aluno->credencial)
                ->whereDate('MOV_DATAHORA', '>=', $form['start']->format('Y-m-d'))
                ->whereDate('MOV_DATAHORA', '<=', $form['end']->format('Y-m-d'))
                ->get();

            $diasAcesso = [];

            foreach ($alunoAcesos as $acesso) {
                if (!in_array($acesso->MOV_DATAHORA->dayOfYear, $diasAcesso)) {
                    $diasAcesso[] = $acesso->MOV_DATAHORA->dayOfYear;
                    $diasPresentes += 1;
                }
            }

            $aluno->faltas = $diasLetivos - $diasPresentes;

            if ($aluno->faltas > 0) {
                $aluno->faltas_percentual = round($aluno->faltas / $diasLetivos * 100, 2);
            } else {
                $aluno->faltas_percentual = 0;
            }

            return $aluno;

        });

        $alunos->setCollection(
            $alunos->getCollection()->sortByDesc('faltas')
        );

        $alunos->appends([
            'start' => $form['start']->format('Y-m-d'),
            'end' => $form['end']->format('Y-m-d'),
            'search' => $form['search']
        ]);

        return view('catracas.relatorios.index', compact(['alunos', 'form', 'diasLetivos']));
    }

    /*public function alunos(Request $request)
    {
        $search = $request->get('search');

        if ($search && strlen($search) > 0) {
            $alunos = Aluno::where('nome', 'like', "%{$search}%")
                ->orderBy('nome')
                ->get();
        } else {
            $alunos = Aluno::orderBy('nome')->get();
        }

        return response()->json($alunos);
    }

    public function acessos(Request $request)
    {
        $start = $request->get('start') ?
            Carbon::createFromTimestamp(strtotime($request->get('start'))) :
            Carbon::now()->addDays(-16);

        $end = $request->get('end') ?
            Carbon::createFromTimestamp(strtotime($request->get('end'))) :
            Carbon::now();

        $acessos = Acesso::select('CRED_NUMERO', 'MOV_DATAHORA')
            ->whereDate('MOV_DATAHORA', '>=', $start->format('Y-m-d'))
            ->whereDate('MOV_DATAHORA', '<=', $end->format('Y-m-d'))
            ->get();

        return response()->json($acessos);
    }*/

}
