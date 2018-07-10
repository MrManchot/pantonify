Dropzone.autoDiscover = false;

$(document).ready(function () {

    $('#pantonify-dropzone').dropzone({
        acceptedFiles: 'image/*',
        init: function () {
            this.on('success', function (uploaded_file) {
                $.post('ajax.php', {filename: uploaded_file.name}, function (data) {
                    $('#pantonify-dropzone').slideUp();
                    $('#pantonify-tools').fadeIn();
                    $('#pantonify-container').html(data.html).css('grid-template-columns', 'repeat(' + data.columns + ',1fr)');
                    color_block_height();
                }, 'json');

            });
        }
    });

    $('#pantonify-tools .print button').on('click', function() {
        window.print();
    });

    $('#pantonify-tools .redo button').on('click', function() {
        $('#pantonify-dropzone').slideDown();
    });

    $('#pantonify-tools .buy button').on('click', function() {
        alert('Not yet !');
    });

});

$( window ).resize(function() {
    color_block_height();
});

function color_block_height() {
    var color_width = $('#pantonify-container .color-block:first-child').width();
    $('#pantonify-container .color-block').css('height', color_width);
}

