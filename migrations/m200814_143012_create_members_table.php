<?php

use yii\db\Migration;

/**
 * Handles the creation of table `members`.
 */
class m200814_143012_create_members_table extends Migration
{
    private $foreignKeys = [
        'company_id' => 'companies',
        'department_id' => 'departments',
        'position_id' => 'positions'
    ];

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $columns = [
            'id' => $this->primaryKey(),
            'full_name' => $this->string(200)->notNull(),
            'role' => $this->string(10)->notNull(), // enum
            'gender' => $this->string(10)->notNull(), // enum
            'birth_date' => $this->date()->notNull(),
            'nationality' => $this->string(100)->notNull(),
            'passport_number' => $this->string(20)->notNull()
        ];

        foreach ($this->foreignKeys as $column => $_) {
            $columns[$column] = $this->integer()->null()->unsigned();
        }

        $this->createTable('members', $columns);

        foreach ($this->foreignKeys as $column => $table) {
            $this->createIndex(
                'idx-members-'.$column,
                'members',
                $column
            );

            $this->addForeignKey(
                'fk-members-'.$column,
                'members',
                $column,
                $table,
                'id',
                'CASCADE',
                'CASCADE'
            );
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        foreach ($this->foreignKeys as $column => $_) {
            $this->dropForeignKey('fk-members-'.$column, 'members');
            $this->dropIndex('idx-members-'.$column, 'members');
        }

        $this->dropTable('members');
    }
}
