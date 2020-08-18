<?php

namespace app\controllers;

use Yii;
use yii\data\Pagination;
use yii\web\ErrorAction;
use yii\web\Controller;
use yii\web\UploadedFile;
use yii\helpers\ArrayHelper;
use app\models\UploadForm;
use app\models\Company;
use app\models\Department;
use app\models\Position;
use app\models\Country;
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
        $companies = Company::find()
            ->orderBy(['name' => SORT_ASC])
            ->all();

        $departments = Department::find()
            ->orderBy(['name' => SORT_ASC])
            ->all();

        $positions = Position::find()
            ->orderBy(['name' => SORT_ASC])
            ->all();

        $countries = Country::find()
            ->orderBy(['name' => SORT_ASC])
            ->all();

        $conditions = ArrayHelper::filter(
            Yii::$app->request->get(),
            ['company_id', 'department_id', 'position_id', 'country_id']
        );

        $conditions = array_filter($conditions, function ($value) {
            return (int) $value !== 0;
        });

        $query = Member::find();

        if (!empty($conditions)) {
            $query->where($conditions);
        }

        $pagination = new Pagination(['totalCount' => (clone $query)->count()]);

        $members = $query
            ->with('company', 'department', 'position', 'country')
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return $this->render('list', compact(
            'companies',
            'departments',
            'positions',
            'countries',
            'members',
            'pagination'
        ));
    }
}
