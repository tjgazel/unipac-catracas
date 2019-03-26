$(document).ready(function () {

    let dadosCalendario = JSON.parse($('#dadosCalendario').val());
    let marcadores = JSON.parse($('#marcadores').val());

    marcadores.forEach(e => {
        $('#marcadorId').append('<option class="' + e.classe + '" value="' + e.id + '">' + e.nome + '</option>');
    });

    $('.calendar').click(function () {
        let marcadorId = $(this).attr('marcador-id');
        let dia = $(this).attr('dia');
        let diaAno = $(this).attr('dia-ano');
        let mes = $(this).attr('mes');
        let ano = $(this).attr('ano');

        $('#marcadorModalLabel').text('Inserir marcador no dia ' + dia + ' de ' + mes + ' de ' + ano);
        $('#marcadorId').val(marcadorId);
        $('#diaAno').val(diaAno);
        $('#ano').val(ano);

        $('#marcadorModal').modal('show');
    });
});
