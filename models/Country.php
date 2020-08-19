<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\db\ActiveQuery;
use app\db\ActiveRecordTrait;

/**
 * This is the model class for table "countries".
 *
 * @property int $id
 * @property string $name
 *
 * @property Member[] $members
 */
class Country extends ActiveRecord
{
    use ActiveRecordTrait;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'countries';
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
            [['name'], 'string', 'max' => 250],
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
        return $this->hasMany(Member::class, ['country_id' => 'id']);
    }
}
