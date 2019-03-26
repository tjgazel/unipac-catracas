@extends('template.default')
@section('title', 'Calendários - ')
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
                            <a class="nav-link" href="{{route('calendarios.create')}}">
                                <i class="far fa-calendar-plus"></i> Criar novo
                            </a>
                        </nav>
                    </div>
                </div>
            </div>
            <div class="col-md-8 col-lg-9">
                <h2>Calendários cadastrados</h2>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                        <tr class="bg-info text-white">
                            <th>Identificação</th>
                            <th>Data Início</th>
                            <th>Data Término</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($calendarios as $calendario)
                            <tr>
                                <td>{{$calendario->identificacao}}</td>
                                <td>{{$calendario->data_inicio->format('d/m/Y')}}</td>
                                <td>{{$calendario->data_termino->format('d/m/Y')}}</td>
                                <td class="btn-actions">
                                    <a href="#" onclick="event.preventDefault()" class="btn btn-danger btn-sm"
                                       data-toggle="modal" data-target="#removeModal-{{$calendario->id}}">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                    <a href="{{route('calendarios.edit', ['calendar' => $calendario])}}"
                                       class="btn btn-warning btn-sm">
                                        <i class="far fa-edit"></i>
                                    </a>
                                    <a href="{{route('calendarios.show', ['calendar' => $calendario])}}"
                                       class="btn btn-primary btn-sm">
                                        <i class="fas fa-search"></i>
                                    </a>
                                    @include('calendarios.remove-modal', ['calendario' => $calendario])
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                {{$calendarios->links()}}

            </div>
        </div>
    </div>
@endsection
