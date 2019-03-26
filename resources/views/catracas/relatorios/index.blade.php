@extends('template.default')
@section('title', ' Relatório de faltas - ')
@section('content')
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page"><i class="fas fa-cogs"></i> Catracas</li>
                <li class="breadcrumb-item active" aria-current="page"><i class="far fa-chart-bar"></i> Relatórios de
                    faltas
                </li>
            </ol>
        </nav>
        <form action="{{route('catracas.relatorios.index')}}" method="get">
            <div class="form-row mb-3">
                <div class="form-group col-12 col-md-4">
                    <label><i class="far fa-calendar-alt"></i> Data inicial</label>
                    <input type="date" name="start" class="form-control" value="{{$form['start']->format('Y-m-d')}}">
                </div>
                <div class="form-group col-12 col-md-4">
                    <label><i class="far fa-calendar-alt"></i> Data final</label>
                    <input type="date" name="end" class="form-control" value="{{$form['end']->format('Y-m-d')}}">
                </div>
                <div class="col-12 col-md-4">
                    <label><i class="fas fa-user-graduate"></i> Aluno
                        <small>(Opcional)</small>
                    </label>
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Nome ou parte do nome"
                               value="{{$form['search']}}">
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                            <a href="{{route('catracas.relatorios.index')}}" class="btn btn-outline-secondary"
                               type="button">
                                <i class="fas fa-eraser"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <p class="col-12"><i class="far fa-calendar-check"></i> Dias letivos no período selecionado:
                    <strong>{{$diasLetivos}}</strong>
            </div>
        </form>

        <h4 class="mb-3"><i class="fas fa-list"></i> Registros de alunos com alto indice de faltas</h4>
        </p>
        <div class="table-responsive">
            <table class="table table-sm table-hover">
                <thead>
                <tr>
                    <th><i class="far fa-id-card"></i> Credencial</th>
                    <th><i class="fas fa-user-graduate"></i> Aluno</th>
                    <th class="text-center">Período</th>
                    <th>Curso</th>
                    <th class="text-center"><i class="fas fa-phone"></i> Fixo</th>
                    <th class="text-center"><i class="fas fa-mobile-alt"></i> Celular</th>
                    <th class="text-center"><i class="far fa-calendar-times"></i> Faltas</th>
                    <th class="text-center"><i class="fas fa-percent"></i> Faltas</th>
                    {{--<th class="text-center"><i class="fas fa-history"></i> Histórico</th>--}}
                </tr>
                </thead>
                <tbody>
                @foreach($alunos as $aluno)
                    <tr>
                        <td class="align-middle">{{$aluno->credencial ?? ''}}</td>
                        <td class="align-middle">{{$aluno->nome ?? ''}}</td>
                        <td class="align-middle text-center">{{$aluno->periodo ?? ''}}</td>
                        <td class="align-middle">{{$aluno->curso ?? ''}}</td>
                        <td class="align-middle text-center">{{$aluno->fixo ?? ''}}</td>
                        <td class="align-middle text-center">{{$aluno->celular ?? ''}}</td>
                        <td class="align-middle text-center">{{$aluno->faltas ?? ''}} / {{$diasLetivos}}</td>
                        <td class="align-middle text-center {{$aluno->faltas_percentual < 60 && $aluno->faltas_percentual > 45 ? 'bg-warning' :
                                $aluno->faltas_percentual >= 60  ? 'bg-danger text-white' : ''}}">
                            {{$aluno->faltas_percentual}}%
                        </td>
                        {{--<td class="align-middle text-center">
                            <a href="{{route('catracas.show', ['id' => $aluno->credencial])}}"><i class="far fa-paper-plane"></i></a>
                        </td>--}}
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection
