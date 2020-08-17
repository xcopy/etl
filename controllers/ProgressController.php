<?php

namespace app\controllers;

use Yii;
use yii\web\Response;
use yii\web\Controller;
use app\models\Company;
use app\models\Department;
use app\models\Position;
use app\models\Member;
use yii\db\ActiveRecord;

class ProgressController extends Controller
{
    public function actionIndex()
    {
        $content = file_get_contents(sprintf(
            '%s/uploads/%s',
            Yii::getAlias('@webroot'),
            // todo: keep POST request only
            Yii::$app->request->isPost ? Yii::$app->request->post('file') : Yii::$app->request->get('file')
        ));

        $containers = explode("\n---\n", $content);

        $totalRows = 0;

        /*
        Member::deleteAll();
        Position::deleteAll();
        Department::deleteAll();
        Company::deleteAll();
        */

        foreach ($containers as $container) {
            $rows = explode("\n", $container);

            $totalRows = $totalRows + count($rows);

            /** @var $company string */
            $company = array_shift($rows);
            [$name, $registration_number, $address, $description] = explode(';', $company);

            // create company
            $this->create(
                Company::class,
                compact('name', 'registration_number', 'address', 'description')
            );

            foreach ($rows as $row) {
                [
                    $department, $position,
                    $full_name, $role, $gender, $birth_date, $nationality, $passport_number
                ] = explode(';', $row);

                // create department & position
                $this->create(Department::class, ['name' => $department]);
                $this->create(Position::class, ['name' => $position]);

                // create members
                $this->create(
                    Member::class,
                    compact('full_name', 'role', 'gender', 'birth_date', 'nationality', 'passport_number')
                );
            }
        }

        $totalMembers = Member::find()->count();

        Yii::$app->request->isPost && (Yii::$app->response->format = Response::FORMAT_JSON);

        return compact('totalRows', 'totalMembers');
    }

    /**
     * Creates record in database
     *
     * @param string $class model class name
     * @param array $attributes attributes/values
     */
    private function create(string $class, array $attributes): void
    {
        /** @var $model ActiveRecord */
        $model = new $class;
        $model->setAttributes($attributes);
        $model->save(); // will run validation anyway
    }
}
