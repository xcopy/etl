<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\db\ActiveQuery;
use app\db\ActiveRecordTrait;

/**
 * This is the model class for table "departments".
 *
 * @property int $id
 * @property string $name
 *
 * @property Member[] $members
 */
class Department extends ActiveRecord
{
    use ActiveRecordTrait;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'departments';
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 150],
            [['name'], 'unique'],
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
        ];
    }

    /**
     * Gets query for [[Members]].
     *
     * @return ActiveQuery
     */
    public function getMembers()
    {
        return $this->hasMany(Member::class, ['department_id' => 'id']);
    }
}
