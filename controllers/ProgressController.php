<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Company;
use app\models\Department;
use app\models\Position;
use app\models\Member;
// use app\models\Relation;
use yii\db\ActiveRecord;

class ProgressController extends Controller
{
    public function actionIndex()
    {
        $content = file_get_contents(sprintf(
            '%s/uploads/%s',
            Yii::getAlias('@webroot'),
            Yii::$app->request->post('file')
        ));

        $containers = explode("\n---\n", $content);

        $totalRows = 0;
        $totalMembers = 0;

        /*
        foreach ([Member::tableName(), Company::tableName(), Department::tableName(), Position::tableName()] as $table) {
            Yii::$app->db->createCommand('TRUNCATE TABLE '.$table.' CASCADE')->execute();
            Yii::$app->db->createCommand('ALTER SEQUENCE '.$table.'_id_seq RESTART WITH 1')->execute();
        }
        */

        foreach ($containers as $container) {
            $rows = explode("\n", $container);

            $company = array_shift($rows);
            [$name, $registration_number, $address, $description] = explode(';', $company);

            // create company
            $company_id = ($company = Company::findOne(['name' => $name]))
                ? $company->getPrimaryKey()
                : $this->create(
                    Company::class,
                    compact('name', 'registration_number', 'address', 'description')
                );

            // calculate number of members after company extracted
            $totalRows = $totalRows + count($rows);

            foreach ($rows as $row) {
                [
                    $department, $position,
                    $full_name, $role, $gender, $birth_date, $nationality, $passport_number
                ] = explode(';', $row);

                $department_id = null;
                $position_id = null;

                if ($role === Member::ROLE_MEMBER) {
                    // find OR create department
                    $condition = ['name' => $department];
                    $department_id = ($department = Department::findOne($condition))
                        ? $department->getPrimaryKey()
                        : $this->create(Department::class, $condition);

                    // find OR create position
                    $condition = ['name' => $position];
                    $position_id = ($position = Position::findOne($condition))
                        ? $position->getPrimaryKey()
                        : $this->create(Position::class, $condition);
                }

                // create member
                $member_id = $this->create(
                    Member::class,
                    compact(
                        'full_name','role', 'gender', 'birth_date', 'nationality', 'passport_number',
                        'company_id', 'department_id', 'position_id'
                    )
                );

                if ($member_id) {
                    $totalMembers++;
                }
            }
        }

        return $this->asJson(compact('totalRows', 'totalMembers'));
    }

    /**
     * Creates record in database
     *
     * @param string $class model class name
     * @param array $attributes attributes/values
     * @return int|null primary key on insert OR null on update
     */
    private function create(string $class, array $attributes)
    {
        /** @var $model ActiveRecord */
        $model = new $class;
        $model->setAttributes($attributes);
        $model->save(); // will run validation anyway

        return $model->getPrimaryKey();
    }
}
