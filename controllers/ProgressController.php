<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Company;
use app\models\Department;
use app\models\Position;
use app\models\Member;
// use app\models\Relation;

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
            $company_id = Company::firstOrCreate(
                ['name' => $name],
                compact('name', 'registration_number', 'address', 'description')
            )->getPrimaryKey();

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
                    $department_id = Department::firstOrCreate(['name' => $department])
                        ->getPrimaryKey();

                    // find OR create position
                    $position_id = Position::firstOrCreate(['name' => $position])
                        ->getPrimaryKey();
                }

                // create member
                $member = new Member;
                $member->setAttributes(compact(
                    'full_name','role', 'gender', 'birth_date', 'nationality', 'passport_number',
                    'company_id', 'department_id', 'position_id'
                ));

                if ($member->save()) {
                    $totalMembers++;
                }
            }
        }

        return $this->asJson(compact('totalRows', 'totalMembers'));
    }
}
