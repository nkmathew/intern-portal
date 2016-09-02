<?php

use yii\db\Migration;

/**
 * Handles adding role to table `signuplinks`.
 */
class m160903_135646_add_role_to_signuplinks extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('signuplinks', 'role', $this->string());
        $this->addForeignKey(
          'FK_singuplinks_user_roles',
          'signuplinks', 'role', 'user_roles', 'role_name');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey(
            'FK_singuplinks_user_roles',
            'signuplinks'
        );
        $this->dropColumn('signuplinks', 'role');
    }
}
