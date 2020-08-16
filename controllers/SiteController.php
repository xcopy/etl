<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\web\UploadedFile;
use app\models\UploadForm;

class SiteController extends Controller
{
    /**
     * Shows upload form & uploads file to local filesystem
     *
     * @return array|string
     */
    public function actionIndex()
    {
        $model = new UploadForm();

        if (Yii::$app->request->isPost) {
            $model->sampleFile = UploadedFile::getInstance($model, 'sampleFile');

            Yii::$app->response->format = Response::FORMAT_JSON;

            return [
                'uploaded' => $model->upload(),
                'file' => $model->sampleFile,
                'errors' => $model->getErrors('sampleFile')
            ];
        }

        return $this->render('index', ['model' => $model]);
    }
}
