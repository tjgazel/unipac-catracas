@extends('layouts.default')
@section('title', 'Relatórios - ')
@section('content')
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page"><i class="fas fa-cogs"></i> Catracas</li>
                <li class="breadcrumb-item">
                    <a href="{{route('catracas.index')}}">
                        <i class="fas fa-list"></i> Registros diários
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    <i class="far fa-id-card"></i> Credencial: {{$credAcessos->first()->CRED_NUMERO}}
                </li>
            </ol>
        </nav>
        <form action="{{route('catracas.show', ['id' => $id])}}" method="get">
            <div class="form-row mb-3">
                <div class="form-group col-12 col-md-4">
                    <label>Data inicial</label>
                    <input type="date" name="start" class="form-control" value="{{$form['start']}}">
                </div>
                <div class="col-12 col-md-4">
                    <label>Data final</label>
                    <div class="input-group">
                        <input type="date" name="end" class="form-control" value="{{$form['end']}}">
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                            <a href="{{route('catracas.show', ['id' => $id])}}" class="btn btn-outline-secondary"
                               type="button">
                                <i class="fas fa-eraser"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <h4 class="mb-3">
            <i class="fas fa-user-graduate"></i> Aluno:
        </h4>
        <div class="table-responsive">
            <table class="table table-sm table-striped">
                <thead>
                <tr>
                    <th><i class="far fa-calendar-alt"></i> Data</th>
                    <th class="text-center"><i class="far fa-clock"></i> Hora</th>
                </tr>
                </thead>
                <tbody>
                @foreach($credAcessos as $credAcesso)
                    <tr>
                        <td>{{$credAcesso->CRAC_ULTPASSAGEM->format('d/m/Y')}}</td>
                        <td class="text-center">{{$credAcesso->CRAC_ULTPASSAGEM->format('H:i:s')}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        {{--{{$credenciais->links()}}--}}
    </div>

@endsection
