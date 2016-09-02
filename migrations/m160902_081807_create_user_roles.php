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
        $this->createTable('user_roles', [
            'id' => $this->primaryKey(),
            'role_name' => $this->string()->unique(),
            'description' => $this->string()
        ]);

        $this->batchInsert('user_roles',
            ['role_name', 'description'],
            [
                [
                    'superuser',
                    'System administrator',
                ],
                [
                    'supervisor',
                    'Supervises student progress'
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
