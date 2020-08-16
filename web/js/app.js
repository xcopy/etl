$(function () {
    var $formText = $('.form-text', '#UploadForm');

    $('#uploadform-file').fileupload({
        maxNumberOfFiles: 1,
        acceptFileTypes: /^text\/(plain|csv)$/i,
        maxFileSize: 8e+8
    }).on('fileuploadadd', function () {
        $formText.empty();
    }).on('fileuploadfail', function () {
        $formText.text('Something went wrong. Please try again.');
    }).on('fileuploaddone', function (e, data) {
        var fileName = data.result.file.name,
            errors = data.result.errors;

        if (errors.length) {
            errors.forEach(function (error) {
                $formText
                    .removeClass('text-success')
                    .addClass('text-danger')
                    .append('<div>' + error + '</div>');
            });
        } else {
            $formText
                .removeClass('text-danger')
                .addClass('text-success')
                .text('File "' + fileName + '" uploaded successfully');
        }
    });
});
