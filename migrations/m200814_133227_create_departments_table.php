<?php

use yii\db\Migration;

/**
 * Handles the creation of table `departments`.
 */
class m200814_133227_create_departments_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('departments', [
            'id' => $this->primaryKey(),
            'name' => $this->string(150)->notNull()->unique()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('departments');
    }
}
