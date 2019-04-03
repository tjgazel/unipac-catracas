$(document).ready(function () {
  var dadosCalendario = JSON.parse($('#dadosCalendario').val());
  var marcadores = JSON.parse($('#marcadores').val());
  marcadores.forEach(function (e) {
    $('#marcadorId').append('<option class="' + e.classe + '" value="' + e.id + '">' + e.nome + '</option>');
  });
  $('.calendar').click(function () {
    var marcadorId = $(this).attr('marcador-id');
    var dia = $(this).attr('dia');
    var diaAno = $(this).attr('dia-ano');
    var mes = $(this).attr('mes');
    var ano = $(this).attr('ano');
    $('#marcadorModalLabel').text('Inserir marcador no dia ' + dia + ' de ' + mes + ' de ' + ano);
    $('#marcadorId').val(marcadorId);
    $('#diaAno').val(diaAno);
    $('#ano').val(ano);
    $('#marcadorModal').modal('show');
  });
});
