@extends('template.default')
@section('title', 'Calendários - ' . $action)
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-lg-3">
                <div class="card">
                    <div class="card-header">
                        Ações
                    </div>
                    <div class="card-body">
                        <nav class="nav flex-column">
                            <a class="nav-link" href="{{route('calendarios.index')}}">
                                <i class="fas fa-undo"></i> Voltar
                            </a>
                        </nav>
                    </div>
                </div>
            </div>
            <div class="col-md-8 col-lg-9">
                <h2>{{$action == 'create' ? 'Cadastar novo calendário' : 'Editar calendário'}}</h2>

                <form method="post" action="{{$action == 'create' ? route('calendarios.store') : route('calendarios.update', ['calendario' => $calendario])}}">
                    @csrf
                    @if($action == 'edit') @method('PUT') @endif
                    <div class="row">
                        <div class="form-group col-12">
                            <label>Identidicação</label>
                            <input type="text" name="identificacao" value="{{old('identificacao') ?? $calendario->identificacao ?? ''}}"
                                   class="form-control {{$errors->has('identificacao') ? 'is-invalid' : ''}}">
                            <span class="small text-danger">{{$errors->first('identificacao')}}</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-6">
                            <label>Data início</label>
                            <input type="date" name="data_inicio" value="{{old('data_inicio') ?? isset($calendario->data_inicio) ? $calendario->data_inicio->format('Y-m-d') : ''}}"
                                   class="form-control {{$errors->has('data_inicio') ? 'is-invalid' : ''}}">
                            <span class="small text-danger">{{$errors->first('data_inicio')}}</span>
                        </div>
                        <div class="form-group col-6">
                            <label>Data término</label>
                            <input type="date" name="data_termino" value="{{old('data_termino') ?? isset($calendario->data_termino) ? $calendario->data_termino->format('Y-m-d') : ''}}"
                                   class="form-control {{$errors->has('data_termino') ? 'is-invalid' : ''}}">
                            <span class="small text-danger">{{$errors->first('data_termino')}}</span>
                        </div>
                    </div>
                    {{--<div class="form-group">
                        <label>Quantidade de meses</label>
                        <input type="number" name="quantidade_meses" value="{{old('quantidade_meses') ?? ''}}"
                               step="1" class="form-control {{$errors->has('quantidade_meses') ? 'is-invalid' : ''}}">
                        <span class="small text-danger">{{$errors->first('quantidade_meses')}}</span>
                    </div>--}}
                    <div class="row">
                        <div class="col-12 text-right">
                            <a href="{{route('calendarios.index')}}" class="btn btn-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-primary">Salvar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection



