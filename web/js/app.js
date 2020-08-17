(function () {
    var alert = {
        shown: false,
        type: 'dark',
        message: '',
        spinner: false
    };

    new Vue({
        el: '#app',
        data: {
            alert: Object.assign({}, alert)
        },
        mounted: function () {
            var vm = this;

            $('#uploadform-file').fileupload({
                maxNumberOfFiles: 1,
                acceptFileTypes: /^text\/(plain|csv)$/i,
                maxFileSize: 8e+8
            }).on('fileuploadadd', function () {
                Object.assign(vm.alert, alert);
            }).on('fileuploaddone', function (e, data) {
                var file = data.result.file.name,
                    errors = data.result.errors,
                    type = 'success',
                    message = 'File "' + file + '" uploaded successfully';

                if (errors.length) {
                    errors = errors.map(function (error) {
                        return '<div>' + error + '</div>';
                    });

                    type = 'danger';
                    message = errors.join('');
                }

                Object.assign(vm.alert, {
                    shown: true,
                    type: type,
                    message: message,
                    spinner: errors.length === 0
                });

                if (errors.length === 0) {
                    $.post('/progress', {file: file}, function (response) {
                        var success = response.totalRows && response.totalMembers &&
                            (response.totalRows === response.totalMembers);

                        message = success
                            ? 'Import completed successfully (' + response.totalMembers + ' of ' + response.totalRows + ')'
                            : 'Something went wrong. Please try again';

                        Object.assign(vm.alert, {
                            shown: true,
                            type: success ? 'success' : 'danger',
                            message: message,
                            spinner: false
                        });
                    });
                }
            });
        }
    });
})();