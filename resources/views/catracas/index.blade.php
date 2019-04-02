@extends('template.default')
@section('title', 'Registros diários catracas - ')
@section('content')
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page"><i class="fas fa-cogs"></i> Catracas</li>
                <li class="breadcrumb-item active" aria-current="page"><i class="fas fa-list"></i> Registros diários
                </li>
            </ol>
        </nav>
        <form action="{{route('catracas.index')}}" method="get">
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
                    <label><i class="fas fa-user-graduate"></i> Aluno</label>
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Opcional"
                               value="{{$form['search']}}">
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                            <a href="{{route('catracas.index')}}" class="btn btn-outline-secondary" type="button">
                                <i class="fas fa-eraser"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <h4 class="mb-3"><i class="fas fa-list"></i> Registros de passagem nas catracas</h4>
        <div class="table-responsive">
            <table class="table table-sm table-striped">
                <thead>
                <tr>
                    <th><i class="far fa-id-card"></i> Credencial</th>
                    <th><i class="fas fa-user-graduate"></i> Aluno</th>
                    <th class="text-center">Curso</th>
                    <th>Período</th>
                    <th class="text-center"><i class="far fa-calendar-alt"></i> Data</th>
                    <th class="text-center"><i class="far fa-clock"></i> Hora</th>
                    <th class="text-right">Detalhes</th>
                </tr>
                </thead>
                <tbody>
                @foreach($credenciais as $credencial)
                        <tr>
                            <td>{{$credencial->CRED_NUMERO ?? ''}}</td>
                            <td>{{$credencial->getAluno->nome ?? ''}}</td>
                            <td class="text-center">{{$credencial->getAluno->curso ?? ''}}</td>
                            <td class="text-center">{{$credencial->getAluno->periodo ?? ''}}</td>
                            <td class="text-center">
                                {{$credencial->CRED_ULTPASSAGEM ? $credencial->CRED_ULTPASSAGEM->format('d/m/Y') : ''}}
                            </td>
                            <td class="text-center">
                                {{$credencial->CRED_ULTPASSAGEM ? $credencial->CRED_ULTPASSAGEM->format('H:i:s') : ''}}
                            </td>
                            <td class="btn-actions">
                                <a href="{{route('catracas.show', ['id' => $credencial->CRED_NUMERO])}}"
                                   class="btn btn-primary btn-sm">
                                    <i class="fas fa-search"></i>
                                </a>
                            </td>
                        </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        @if($credenciais instanceof \Illuminate\Pagination\LengthAwarePaginator)
            {{$credenciais->links()}}
        @endif
    </div>

@endsection
