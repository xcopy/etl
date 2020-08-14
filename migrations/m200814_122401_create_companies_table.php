<?php

use yii\db\Migration;

/**
 * Handles the creation of table `companies`.
 */
class m200814_122401_create_companies_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('companies', [
            'id' => $this->primaryKey(),
            'name' => $this->string(100)->notNull()->unique(),
            'registration_number' => $this->string(50)->notNull()->unique(),
            'address' => $this->text()->notNull(),
            'description' => $this->text()->null()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('companies');
    }
}
