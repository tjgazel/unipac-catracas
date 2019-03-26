<div class="modal fade" id="marcadorModal" tabindex="-1" role="dialog"
     aria-labelledby="marcadorModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="marcadorModalLabel">Inserir Evento</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('calendarios.add-marcador')}}" method="post">
                @csrf
                <input type="hidden" name="calendario_id" value="{{$calendario->id}}" id="calendarioId">
                <input type="hidden" name="dia" id="diaAno">
                <input type="hidden" name="ano" id="ano">

                <div class="modal-body">
                    <div class="form-group">
                        <label>Marcadores</label>
                        <select name="marcador_id" value="1" class="form-control" id="marcadorId"></select>
                    </div>

                    <input type="hidden" name="dia_sabado_letivo" id="diaAno">
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">cancelar</button>
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </div>

            </form>
        </div>
    </div>
</div>
