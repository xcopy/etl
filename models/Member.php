<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\db\ActiveQuery;
use yii\base\InvalidConfigException;

/**
 * This is the model class for table "members".
 *
 * @property int $id
 * @property string $full_name
 * @property string $role
 * @property string $gender
 * @property string $birth_date
 * @property string $passport_number
 * @property int|null $company_id
 * @property int|null $department_id
 * @property int|null $position_id
 * @property int|null $country_id
 * @property string $family_id
 *
 * @property Company $company
 * @property Country $country
 * @property Department $department
 * @property Position $position
 * @property Member[] $relatives
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
            [['family_id', 'full_name', 'role', 'gender', 'birth_date', 'passport_number'], 'required'],
            [['birth_date'], 'safe'],
            [['company_id', 'department_id', 'position_id', 'country_id'], 'default', 'value' => null],
            [['company_id', 'department_id', 'position_id', 'country_id'], 'integer'],
            [['family_id'], 'string', 'max' => 255],
            [['full_name'], 'string', 'max' => 200],
            [['role', 'gender'], 'string', 'max' => 10],
            [['passport_number'], 'string', 'max' => 20],
            [['company_id'], 'exist', 'skipOnError' => true, 'targetClass' => Company::class, 'targetAttribute' => ['company_id' => 'id']],
            [['country_id'], 'exist', 'skipOnError' => true, 'targetClass' => Country::class, 'targetAttribute' => ['country_id' => 'id']],
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
            'passport_number' => 'Pass. No.',
            'company_id' => 'Company',
            'department_id' => 'Department',
            'position_id' => 'Position',
            'country_id' => 'Country',
            'family_id' => 'Family'
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
     * Gets query for [[Country]].
     *
     * @return ActiveQuery
     */
    public function getCountry()
    {
        return $this->hasOne(Country::class, ['id' => 'country_id']);
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

    /**
     * Gets query for [[Relatives]].
     *
     * @return ActiveQuery
     * @throws InvalidConfigException
     */
    public function getRelatives()
    {
        return $this->hasMany(Member::class, ['id' => 'relative_id'])->viaTable('relations', ['member_id' => 'id']);
    }

    /**
     * Returns formatted birth date
     *
     * @return string
     */
    public function getBirthDateText()
    {
        return date('d.m.Y', strtotime($this->birth_date));
    }
}
