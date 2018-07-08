Dropzone.autoDiscover = false;

$(document).ready(function () {

    $('#pantonify-dropzone').dropzone({
        acceptedFiles: 'image/*',
        init: function () {
            this.on('success', function (uploaded_file) {
                $.post('ajax.php', {filename: uploaded_file.name}, function (data) {
                    $('#pantonify-dropzone').fadeOut();
                    $('#pantonify-container').html(data.html).css('grid-template-columns', 'repeat(' + data.columns + ',1fr)');
                    $('#pantonify-container .color-block').css('height', $('#pantonify-container .color-block:first-child').width());
                }, 'json');

            });
        }
    });

});