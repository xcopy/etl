<?php

namespace app\controllers;

use Yii;
use yii\db\ActiveRecord;
use yii\web\ErrorAction;
use yii\web\Controller;
use yii\web\UploadedFile;
use app\models\UploadForm;
use app\models\Member;

class SiteController extends Controller
{
    /**
     * {@inheritDoc}
     */
    public function actions()
    {
        return [
            'error' => ['class' => ErrorAction::class],
        ];
    }

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

            return $this->asJson([
                'success' => $model->upload(),
                'file' => $model->file,
                'errors' => $model->getErrors('file')
            ]);
        }

        return $this->render('index', ['model' => $model]);
    }

    /**
     * Renders data
     *
     * @return string
     */
    public function actionList()
    {
        /** @var $members ActiveRecord[] */
        $members = Member::find()
            ->with('company', 'department', 'position')
            ->all();

        return $this->render('list', [
            'members' => $members
        ]);
    }
}
