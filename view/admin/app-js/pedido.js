var podt = $(".datatable").DataTable(
    {
        retrieve: true,
        responsive: true,
        dom: 'Bfrtip',
        buttons: datatable_buttons,
        "displayLength": 30,
        "order": [[0, "desc"]],
        "oLanguage": lang
    });

$(function () {
    $('.btn-remover').on('click', function () {
        $('#modal-remove').modal('show');
        var id = $(this).data('id');
        $('.btn-confirma-remove').on('click', function () {
            var url = $('#form-remove').attr('action');
            $.post(url, {pedido_id: id}, function (rs) {
                $('#modal-remove').modal('hide');
                $('#tr-' + id).fadeOut();
                $.gritter.add({
                    title: 'Procedimento Realizado',
                    text: 'Registro removido com sucesso!',
                    class_name: 'success',
                    before_open: function () {
                        if ($('.gritter-item-wrapper').length == 1) {
                            // prevents new gritter 
                            return false;
                        }
                    }
                });
            });
            return false;
        });
    });
});



