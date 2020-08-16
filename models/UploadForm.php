<?php

namespace app\models;

use yii\base\Model;
use yii\web\UploadedFile;

class UploadForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $file;

    /**
     * {@inheritDoc}
     */
    public function rules(): array
    {
        return [
            [
                ['file'], 'file', 'skipOnEmpty' => false,
                'checkExtensionByMimeType' => false, 'extensions' => 'csv'
            ],
        ];
    }

    /**
     * Saves the uploaded file
     *
     * @return bool
     */
    public function upload(): bool
    {
        return $this->validate()
            ? $this->file->saveAs(
                sprintf(
                    'uploads/%s.%s',
                    $this->file->baseName,
                    $this->file->extension
                )
            )
            : false;
    }
}
