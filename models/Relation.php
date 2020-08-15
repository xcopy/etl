<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "relations".
 *
 * @property int $member_id
 * @property int $relative_id
 *
 * @property Member $member
 * @property Member $relative
 */
class Relation extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'relations';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['member_id', 'relative_id'], 'required'],
            [['member_id', 'relative_id'], 'default', 'value' => null],
            [['member_id', 'relative_id'], 'integer'],
            [['member_id', 'relative_id'], 'unique', 'targetAttribute' => ['member_id', 'relative_id']],
            [['member_id'], 'exist', 'skipOnError' => true, 'targetClass' => Member::class, 'targetAttribute' => ['member_id' => 'id']],
            [['relative_id'], 'exist', 'skipOnError' => true, 'targetClass' => Member::class, 'targetAttribute' => ['relative_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'member_id' => 'Member ID',
            'relative_id' => 'Relative ID',
        ];
    }

    /**
     * Gets query for [[Member]].
     *
     * @return ActiveQuery
     */
    public function getMember()
    {
        return $this->hasOne(Member::class, ['id' => 'member_id']);
    }

    /**
     * Gets query for [[Relative]].
     *
     * @return ActiveQuery
     */
    public function getRelative()
    {
        return $this->hasOne(Member::class, ['id' => 'relative_id']);
    }
}
