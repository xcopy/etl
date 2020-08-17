$(function () {
    var $formText = $('.form-text', '#UploadForm'),
        $alert = $('#alert'),
        $spinner = $('#spinner', $alert),
        $message = $('#message', $alert);

    $('#uploadform-file').fileupload({
        maxNumberOfFiles: 1,
        acceptFileTypes: /^text\/(plain|csv)$/i,
        maxFileSize: 8e+8
    }).on('fileuploadadd', function () {
        $formText.empty();
    }).on('fileuploadfail', function () {
        $formText.text('Something went wrong. Please try again');
        $alert.addClass('d-flex');
    }).on('fileuploaddone', function (e, data) {
        var file = data.result.file.name,
            errors = data.result.errors;

        if (errors.length) {
            errors.forEach(function (error) {
                $formText
                    .removeClass('text-success')
                    .addClass('text-danger')
                    .append('<div>' + error + '</div>');
            });
        } else {
            $alert.removeClass('d-none alert-success alert-danger').addClass('alert-dark');
            $spinner.addClass('d-flex');
            $message.addClass('d-none');

            $formText
                .removeClass('text-danger')
                .addClass('text-success')
                .text('File "' + file + '" uploaded successfully');

            $.post('/progress', {file: file}, function (response) {
                $alert.removeClass('alert-dark');
                $spinner.removeClass('d-flex');
                $message.removeClass('d-none');

                if (response.totalRows && response.totalMembers &&
                    (response.totalRows === response.totalMembers)) {
                    $alert.addClass('alert-success');
                    $message.text('Import completed successfully (' + response.totalMembers + ' of ' + response.totalRows +')');
                } else {
                    $alert.addClass('alert-danger');
                    $message.text('Something went wrong. Please try again');
                }
            });
        }
    });
});
