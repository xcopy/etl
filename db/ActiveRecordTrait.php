<?php

namespace app\db;

use Yii;
use yii\db\ActiveRecord;

trait ActiveRecordTrait
{
    /**
     * Get the first record matching the condition or create it
     *
     * @param mixed $condition
     * @param array $attributes
     * @return ActiveRecord
     */
    public static function firstOrCreate($condition, array $attributes = null)
    {
        /** @var $model ActiveRecord */
        $model = static::findOne($condition);

        if (is_null($model)) {
            $model = new static();
            $model->setAttributes($attributes ?? $condition);
            $model->save(); // will run validation anyway
        }

        return $model;
    }
}
