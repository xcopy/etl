<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\db\ActiveQuery;
use app\db\ActiveRecordTrait;

/**
 * This is the model class for table "companies".
 *
 * @property int $id
 * @property string $name
 * @property string $registration_number
 * @property string $address
 * @property string|null $description
 *
 * @property Member[] $members
 */
class Company extends ActiveRecord
{
    use ActiveRecordTrait;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'companies';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'registration_number', 'address'], 'required'],
            [['address', 'description'], 'string'],
            [['name'], 'string', 'max' => 100],
            [['registration_number'], 'string', 'max' => 50],
            [['name'], 'unique'],
            [['registration_number'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'registration_number' => 'Registration Number',
            'address' => 'Address',
            'description' => 'Description',
        ];
    }

    /**
     * Gets query for [[Members]].
     *
     * @return ActiveQuery
     */
    public function getMembers()
    {
        return $this->hasMany(Member::class, ['company_id' => 'id']);
    }
}
