<?php

namespace app\models;

use yii\base\Model;
use yii\web\UploadedFile;

class UploadForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $sampleFile;

    /**
     * {@inheritDoc}
     */
    public function rules(): array
    {
        return [
            [
                ['sampleFile'], 'file', 'skipOnEmpty' => false,
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
            ? $this->sampleFile->saveAs(
                sprintf(
                    'uploads/%s.%s',
                    $this->sampleFile->baseName,
                    $this->sampleFile->extension
                )
            )
            : false;
    }
}
