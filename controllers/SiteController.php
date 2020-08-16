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
            $model->file = UploadedFile::getInstance($model, 'file');

            Yii::$app->response->format = Response::FORMAT_JSON;

            return [
                'success' => $model->upload(),
                'file' => $model->file,
                'errors' => $model->getErrors('file')
            ];
        }

        return $this->render('index', ['model' => $model]);
    }
}
