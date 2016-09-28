<?php

use yii\db\Migration;

class m160905_191356_drop_role_from_supervisorprofile extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->dropForeignKey(
            'FK_supervisorprofile_user_roles',
            'supervisorprofile'
        );

        $this->dropColumn('supervisorprofile', 'role');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->addColumn('supervisorprofile', 'role', $this->integer());

        $this->addForeignKey(
            'FK_supervisorprofile_user_roles',
            'supervisorprofile', 'role', 'user_roles', 'role_name');
    }
}
