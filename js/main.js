Dropzone.autoDiscover = false;

$(document).ready(function () {
    $('#pantonify-dropzone').dropzone({
        init: function () {
            this.on('success', function (uploaded_file) {
                $.post('ajax.php', { filename: uploaded_file.name}, function( data ) {
                    $('#pantonify-container').html( data );
                });

            });
        }
    });

})