@extends('template.default')
@section('title', 'Calendários - ')
@section('content')
    <div class="container">
        <div class="row">
            <h3 class="text-center col-12">Calendário <br> <small>{{$calendario->identificacao}}</small></h3>
            <div class="col-12 my-3">
                @foreach($marcadores as $marcador)
                    <span class="{{$marcador->classe}} border" style="padding: 0 10px; margin-right: 5px;"></span> {{$marcador->nome}} &nbsp;&nbsp;&nbsp;
                @endforeach
            </div>
        </div>
        <div class="row">
            @foreach($dados as $dado)
                <div class="col-6 col-lg-4 mb-3">
                    <table class="table text-center table-bordered table-sm">
                        <thead>
                        <tr>
                            <th colspan="7" class="bg-light">{{$dado['mes-ano']}}</th>
                        </tr>
                        <tr>
                            <th>Dom</th>
                            <th>Seg</th>
                            <th>Ter</th>
                            <th>Qua</th>
                            <th>Qui</th>
                            <th>Sex</th>
                            <th>Sab</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($dado['semanas'] as $semana)
                            {!! $semana !!}
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @endforeach
        </div>
        <input type="hidden" value="{{$marcadores}}" id="marcadores">
        <input type="hidden" value="{{$calendario->dados}}" id="dadosCalendario">
        @include('calendarios.marcador-form-modal')
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/calendar.js') }}"></script>
@endpush
