<?php

use yii\db\ActiveRecord;
use yii\helpers\Inflector;

/** @var $key string */
/** @var $option ActiveRecord */

?>

<label for="<?=$key ?>" class="m-0">
    <select id="<?=$key ?>" name="<?=$key ?>" class="custom-select">
        <option value="">- <?=Inflector::humanize($key) ?> -</option>
        <?php foreach ($options as $option): ?>
            <option
                value="<?=$option->primaryKey ?>"
                <?php if ((int) Yii::$app->request->get($key) === $option->primaryKey): ?>selected<?php endif ?>>
                <?=$option->getAttribute('name') ?>
            </option>
        <?php endforeach ?>
    </select>
</label>