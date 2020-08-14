<?php

use yii\db\Migration;

/**
 * Handles the creation of table `relations`.
 */
class m200814_155253_create_relations_table extends Migration
{
    private $columns = ['member_id', 'relative_id'];

    private function getUniqIndex() {
        return 'idx-members-'.implode('-', $this->columns);
    }

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $columns = [];

        foreach ($this->columns as $column) {
            $columns[$column] = $this->integer()->notNull()->unsigned();
        }

        $this->createTable('relations', $columns);

        foreach ($this->columns as $column) {
            $this->createIndex(
                'idx-relations-'.$column,
                'relations',
                $column
            );

            $this->addForeignKey(
                'fk-relations-'.$column,
                'relations',
                $column,
                'members',
                'id',
                'CASCADE',
                'CASCADE'
            );
        }

        $this->createIndex(
            $this->getUniqIndex(),
            'relations',
            $this->columns,
            true
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex($this->getUniqIndex(), 'relations');

        foreach ($this->columns as $column) {
            $this->dropForeignKey('fk-relations-'.$column,'relations');
            $this->dropIndex('idx-relations-'.$column,'relations');
        }

        $this->dropTable('relations');
    }
}
