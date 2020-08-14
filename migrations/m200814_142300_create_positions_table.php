<?php

use yii\db\Migration;

/**
 * Handles the creation of table `positions`.
 */
class m200814_142300_create_positions_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('positions', [
            'id' => $this->primaryKey(),
            'name' => $this->string(150)->notNull()->unique()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('positions');
    }
}
