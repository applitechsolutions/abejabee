$(document).ready(function() {
    $('.listarStock').on('submit', function(e) {

        e.prevenDefault();
        $('#modal-stock').modal('show');

    });
});