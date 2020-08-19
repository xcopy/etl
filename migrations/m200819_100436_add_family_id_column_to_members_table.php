<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `members`.
 */
class m200819_100436_add_family_id_column_to_members_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('members', 'family_id', "string not null default ''");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('members', 'family_id');
    }
}
