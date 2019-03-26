<div class="modal fade" id="removeModal-{{$calendario->id}}" tabindex="-1" role="dialog"
     aria-labelledby="removeModalLabel-{{$calendario->id}}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="removeModalLabel-{{$calendario->id}}">Remover Calendário</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('calendarios.destroy', ['calendario' => $calendario])}}" method="post">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    <p class="text-danger">Deseja remover este calendário?</p>
                    <p>{{$calendario->identificacao}}</p>
                    <p>Início {{$calendario->data_inicio->format('d/m/Y')}},
                        Término {{$calendario->data_termino->format('d/m/Y')}}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">cancelar</button>
                    <button type="submit" class="btn btn-danger">Remover</button>
                </div>
            </form>
        </div>
    </div>
</div>
