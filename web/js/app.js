$(function () {
    var $formText = $('.form-text', '#UploadForm');

    $('#uploadform-samplefile').fileupload({
        maxNumberOfFiles: 1,
        acceptFileTypes: /^text\/(plain|csv)$/i,
        maxFileSize: 8e+8
    }).on('fileuploadadd', function (e, data) {
        $formText.empty();
    }).on('fileuploadfail', function (e, data) {
        $formText.text('Something went wrong. Please try again.');
    }).on('fileuploaddone', function (e, data) {
        if (data.result.errors.length) {
            data.result.errors.forEach(function (error) {
                $formText
                    .removeClass('text-success')
                    .addClass('text-danger')
                    .append('<div>' + error + '</div>');
            });
        } else {
            $formText
                .removeClass('text-danger')
                .addClass('text-success')
                .text('File "' + data.result.file.name + '" uploaded successfully');
        }
    });
});
