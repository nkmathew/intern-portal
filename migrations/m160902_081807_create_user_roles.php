<?php

use yii\db\Migration;

/**
 * Handles the creation for table `user_roles`.
 */
class m160902_081807_create_user_roles extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('user_roles', [
            'id' => $this->primaryKey(),
            'role_name' => $this->string()->unique(),
            'description' => $this->string()
        ], $tableOptions);

        $this->batchInsert('user_roles',
            ['role_name', 'description'],
            [
                [
                    'superuser',
                    'System administrator',
                ],
                [
                    'coordinator',
                    "Assesses the intern's progress and work at the end of the internship period"
                ],
                [
                    'supervisor',
                    'Monitors weekly student progress in their placement'
                ],
                [
                    'intern',
                    'Student undergoing industrial attachment'
                ]
            ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('user_roles');
    }
}
