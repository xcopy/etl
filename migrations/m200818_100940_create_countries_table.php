<?php

use yii\db\Migration;

/**
 * Handles the creation of table `countries`.
 */
class m200818_100940_create_countries_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('countries', [
            'id' => $this->primaryKey(),
            'name' => $this->string(250)->notNull()->unique()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('countries');
    }
}
