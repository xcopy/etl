<?php

namespace app\assets;

use yii\web\AssetBundle;

class FileUploadAsset extends AssetBundle
{
    public $sourcePath = '@npm/blueimp-file-upload/js';
    public $js = [
        'vendor/jquery.ui.widget.js',
        // 'jquery.iframe-transport.js',
        'jquery.fileupload.js'
        // 'jquery.fileupload-process.js',
        // 'jquery.fileupload-validate.js',
        // 'jquery.fileupload-ui.js',
    ];
}
