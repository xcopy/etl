<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%members}}`.
 */
class m200818_101951_add_country_id_column_to_members_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('members', 'nationality');
        $this->addColumn('members', 'country_id', 'integer');

        $this->createIndex(
            'idx-members-country_id',
            'members',
            'country_id'
        );

        $this->addForeignKey(
            'fk-members-country_id',
            'members',
            'country_id',
            'countries',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-members-country_id', 'members');
        $this->dropIndex('idx-members-country_id', 'members');

        $this->dropColumn('members', 'country_id');
        $this->addColumn('members', 'nationality', 'string');
    }
}
