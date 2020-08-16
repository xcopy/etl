<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\UploadedFile;
use app\models\UploadForm;

class SiteController extends Controller
{
    /**
     * Shows upload form & uploads file to local filesystem
     *
     * @return string
     */
    public function actionIndex()
    {
        $model = new UploadForm();

        if (Yii::$app->request->isPost) {
            $model->sampleFile = UploadedFile::getInstance($model, 'sampleFile');

            if ($model->upload()) {
                // todo
            }
        }

        return $this->render('index', ['model' => $model]);
    }
}
