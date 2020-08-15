<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "members".
 *
 * @property int $id
 * @property string $full_name
 * @property string $role
 * @property string $gender
 * @property string $birth_date
 * @property string $nationality
 * @property string $passport_number
 * @property int|null $company_id
 * @property int|null $department_id
 * @property int|null $position_id
 *
 * @property Company $company
 * @property Department $department
 * @property Position $position
 */
class Member extends ActiveRecord
{
    const GENDER_MALE = 'MALE';
    const GENDER_FEMALE = 'FEMALE';

    const ROLE_MEMBER = 'MEMBER';
    const ROLE_SPOUSE = 'SPOUSE';
    const ROLE_CHILD  = 'CHILD';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'members';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['full_name', 'role', 'gender', 'birth_date', 'nationality', 'passport_number'], 'required'],
            [['birth_date'], 'safe'],
            [['company_id', 'department_id', 'position_id'], 'default', 'value' => null],
            [['company_id', 'department_id', 'position_id'], 'integer'],
            [['full_name'], 'string', 'max' => 200],
            [['role', 'gender'], 'string', 'max' => 10],
            [['nationality'], 'string', 'max' => 100],
            [['passport_number'], 'string', 'max' => 20],
            [['company_id'], 'exist', 'skipOnError' => true, 'targetClass' => Company::class, 'targetAttribute' => ['company_id' => 'id']],
            [['department_id'], 'exist', 'skipOnError' => true, 'targetClass' => Department::class, 'targetAttribute' => ['department_id' => 'id']],
            [['position_id'], 'exist', 'skipOnError' => true, 'targetClass' => Position::class, 'targetAttribute' => ['position_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'full_name' => 'Full Name',
            'role' => 'Role',
            'gender' => 'Gender',
            'birth_date' => 'Birth Date',
            'nationality' => 'Nationality',
            'passport_number' => 'Passport Number',
            'company_id' => 'Company ID',
            'department_id' => 'Department ID',
            'position_id' => 'Position ID',
        ];
    }

    /**
     * Gets query for [[Company]].
     *
     * @return ActiveQuery
     */
    public function getCompany()
    {
        return $this->hasOne(Company::class, ['id' => 'company_id']);
    }

    /**
     * Gets query for [[Department]].
     *
     * @return ActiveQuery
     */
    public function getDepartment()
    {
        return $this->hasOne(Department::class, ['id' => 'department_id']);
    }

    /**
     * Gets query for [[Position]].
     *
     * @return ActiveQuery
     */
    public function getPosition()
    {
        return $this->hasOne(Position::class, ['id' => 'position_id']);
    }
}
