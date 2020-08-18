<?php

namespace app\controllers;

use Yii;
use yii\data\Pagination;
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
     * Renders paginated members
     *
     * @return string
     */
    public function actionList()
    {
        $query = Member::find();

        $count = $query->count();

        $pagination = new Pagination(['totalCount' => $count]);

        $members = $query
            ->with('company', 'department', 'position')
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return $this->render('list', [
            'members' => $members,
            'pagination' => $pagination
        ]);
    }
}
