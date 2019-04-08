@extends('layouts.default')
@section('content')
    <div class="container">
        <h3 class="mt-3">Usuários do sistema <a href="{{route('gerenciar-usuarios.create')}}"
                                                class="btn btn-secondary float-right">Cadastrar</a></h3>
        <table class="table table-sm table-hover mt-1">
            <thead>
            <tr>
                <th>Nome</th>
                <th>CPF</th>
                <th>Tipo Usuário</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach($usuarios as $usuario)
                <tr>
                    <td>{{$usuario->name}}</td>
                    <td>{{$usuario->cpf}}</td>
                    <td>{{$usuario->tipo_usuario == 1 ? 'Admin' : 'Usuário'}}</td>
                    <td>
                        <a href="#" onclick="event.preventDefault(); document.getElementById('destroy-form{{$usuario->id}}').submit();"
                           class="btn btn-sm btn-outline-danger float-right">
                            <i class="fas fa-trash-alt"></i>
                        </a>
                        <a href="{{route('gerenciar-usuarios.edit', ['id' => $usuario->id])}}"
                           class="btn btn-sm btn-outline-warning float-right mr-3">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form id="destroy-form{{$usuario->id}}" action="{{route('gerenciar-usuarios.destroy', ['id' => $usuario->id])}}" method="POST" style="display: none;">
                            @csrf @method('DELETE')
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

@endsection
