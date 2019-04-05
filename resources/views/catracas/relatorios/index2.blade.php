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
        <form action="{{route('catracas.relatorios.index2')}}" method="get">
            <div class="form-row mb-3">
                <div class="form-group col-12 col-md-4">
                    <label><i class="far fa-calendar-alt"></i> Data inicial</label>
                    <input type="date" name="start" class="form-control" value="{{$form['start']}}">
                </div>
                <div class="form-group col-12 col-md-4">
                    <label><i class="far fa-calendar-alt"></i> Data final</label>
                    <input type="date" name="end" class="form-control" value="{{$form['end']}}">
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
            </div>
        </form>

        <relatorio-index
            dias-letivos="{{$diasLetivos}}"
            data-form="{{$form}}"
            url-alunos="{{route('catracas.relatorios.alunos')}}"
            url-acessos="{{route('catracas.relatorios.acessos')}}">
        </relatorio-index>


    </div>

@endsection
