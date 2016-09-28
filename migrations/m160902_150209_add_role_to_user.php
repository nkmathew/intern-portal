<?php

use yii\db\Migration;

/**
 * Handles adding role to table `user`.
 */
class m160902_150209_add_role_to_user extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('user', 'role', $this->string());
        $this->addForeignKey('FK_user_roles_user', 'user', 'role', 'user_roles', 'role_name');

        $this->insert('user', [
            'auth_key' => '',
            'password_hash' => '$2y$13$EgZmVsH0taLeKwrDR4k49e838RZFqytucF.nDcBFEYKwDKL9sAxMW', // Default password: test123
            'email' => 'admin@admin.com',
            'created_at' => time(),
            'updated_at' => time(),
            'role' => 'superuser',
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        // drops foreign key for table `profile`
        $this->dropForeignKey(
            'FK_user_roles_user',
            'user'
        );

        $this->dropColumn('user', 'role');
    }
}
