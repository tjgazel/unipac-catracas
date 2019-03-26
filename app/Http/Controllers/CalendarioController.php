<?php

namespace App\Http\Controllers;

use App\Http\Requests\CalendarioRequest;
use App\Models\Calendario;
use App\Models\DadosCalendario;
use App\Models\Marcador;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CalendarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $calendarios = Calendario::orderBy('data_inicio', 'DESC')->paginate();

        return view('calendarios.index', compact('calendarios'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $action = 'create';

        return view('calendarios.form', compact('action'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CalendarioRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CalendarioRequest $request)
    {
        $calendario = Calendario::create($request->all());

        toastr()->success('Criado com sucesso');

        return redirect()->route('calendarios.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Calendario $calendario
     * @return \Illuminate\Http\Response
     */
    public function show(Calendario $calendario)
    {
        /** @var $data Carbon */
        $data = $calendario->data_inicio->copy()->startOfMonth();
        $inicioLetivo = $calendario->data_inicio->dayOfYear();
        $finalLetivo = $calendario->data_termino->dayOfYear();
        $quantidadeMeses = $calendario->data_termino->diffInMonths($calendario->data_inicio);

        /* monta os meses */
        for ($m = 0; $m < $quantidadeMeses + 1; $m++) {

            $mes = $data->copy()->format('m');
            $ultimoDiaMes = $data->copy()->endOfMonth()->format('d');

            $dados[$m] = [
                'mes-ano' => ucfirst($data->formatLocalized('%B')) . ' - ' . $data->year,
                'semanas' => []
            ];

            /* monta a linha da semana na tabela */
            for ($s = 0; $s < 6; $s++) {

                $string = '<tr>';

                /* percorre os dias montando suas propriedades */
                for ($d = 0; $d < 7; $d++) {
                    $dadosCalendario = $calendario->dados()->where('dia', $data->dayOfYear)->first();

                    if ($data->dayOfWeek == $d && $data->month == $mes && $data->day <= $ultimoDiaMes) {

                        if ($data->dayOfWeek != 0 && $data->dayOfWeek != 6 && $data->dayOfYear >= $inicioLetivo && $data->dayOfYear <= $finalLetivo) {

                            if ($dadosCalendario) {
                                $string .= '<td class="calendar ' . $dadosCalendario->marcador->classe . '" marcador-id="' . $dadosCalendario->marcador->id . '" dia="' . $data->day . '" mes="' . $data->monthName . '" dia-ano="' . $data->dayOfYear . '" ano="' . $data->year . '">' . $data->day . '</td>';
                            } else {
                                $string .= '<td class="calendar bg-info text-white" marcador-id="2" dia="' . $data->day . '" mes="' . $data->monthName . '" dia-ano="' . $data->dayOfYear . '" ano="' . $data->year . '">' . $data->day . '</td>';
                            }

                        } else {
                            if ($dadosCalendario) {
                                $string .= '<td class="calendar ' . $dadosCalendario->marcador->classe . '" marcador-id="' . $dadosCalendario->marcador->id . '" dia="' . $data->day . '" mes="' . $data->monthName . '" dia-ano="' . $data->dayOfYear . '" ano="' . $data->year . '">' . $data->day . '</td>';
                            } else {
                                $string .= '<td class="calendar bg-white text-dark" marcador-id="1" dia="' . $data->day . '" mes="' . $data->monthName . '" dia-ano="' . $data->dayOfYear . '" ano="' . $data->year . '">' . $data->day . '</td>';
                            }
                        }

                        $data->addDay();
                    } else {
                        $string .= '<td>&nbsp;&nbsp;</td>';
                    }
                }

                $string .= '</tr>';

                array_push($dados[$m]['semanas'], $string);
            }
        }

        $marcadores = Marcador::all();

        return view('calendarios.show', compact(['calendario', 'dados', 'marcadores']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Calendar $calendario
     * @return \Illuminate\Http\Response
     */
    public function edit(Calendario $calendario)
    {
        $action = 'edit';

        return view('calendarios.form', compact(['calendario', 'action']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\CalendarioRequest $request
     * @param  \App\Models\Calendar $calendario
     * @return \Illuminate\Http\Response
     */
    public function update(CalendarioRequest $request, Calendario $calendario)
    {
        $calendario->update($request->all());

        toastr()->success('Atualizado com sucesso');

        return redirect()->route('calendarios.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Calendario $calendario
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Calendario $calendario)
    {
        $calendario->delete();

        toastr()->success('Removido com sucesso');

        return redirect()->route('calendarios.index');
    }

    public function addMarcador(Request $request)
    {
        DB::beginTransaction();

        try {

            if ($request->get('marcador_id') == 1 || $request->get('marcador_id') == 2) {
                $dado = DadosCalendario::where('calendario_id', $request->get('calendario_id'))
                    ->where('dia', $request->get('dia'))
                    ->where('ano', $request->get('ano'))
                    ->first();
                $dado ? $dado->delete() : null;
            } else {
                DadosCalendario::updateOrCreate(
                    ['calendario_id' => $request->get('calendario_id'), 'dia' => $request->get('dia'), 'ano' => $request->get('ano')],
                    ['marcador_id' => $request->get('marcador_id'), 'dia_sabado_letivo' => $request->get('dia_sabado_letivo')]
                );
            }

        } catch (\Exception $e) {

            DB::rollBack();

            toastr()->error($e->getMessage(), 'Erro: informe ao administrador');

            return redirect()->back(409);
        }

        DB::commit();

        toastr()->success('Salvo com sucesso');

        return redirect()->route('calendarios.show', ['id' => $request->get('calendario_id')], 201);
    }
}
