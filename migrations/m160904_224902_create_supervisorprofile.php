<?php

use yii\db\Migration;

/**
 * Handles the creation for table `supervisorprofile`.
 */
class m160904_224902_create_supervisorprofile extends Migration
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

        $this->createTable('supervisorprofile', [
            'id' => $this->primaryKey(),
            'sex' => $this->string(),
            'email' => $this->string()->notNull()->unique(),
            'firstname' => $this->string(),
            'surname' => $this->string(),
            'id_number' => $this->string(),
            'company_name' => $this->string(),
            'company_address' => $this->string(),
            'work_position' => $this->string(),
            'phone_number' => $this->string(),
            'role' => $this->string(),
        ], $tableOptions);

        $this->addForeignKey('FK_supervisorprofile_user',
          'supervisorprofile', 'email', 'user', 'email');

        $this->addForeignKey(
          'FK_supervisorprofile_user_roles',
          'supervisorprofile', 'role', 'user_roles', 'role_name');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey(
            'FK_supervisorprofile_user',
            'supervisorprofile'
        );

        $this->dropForeignKey(
            'FK_supervisorprofile_user_roles',
            'supervisorprofile'
        );

        $this->dropTable('supervisorprofile');
    }
}
