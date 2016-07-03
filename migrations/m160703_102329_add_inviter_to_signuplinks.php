<?php

use yii\db\Migration;

/**
 * Handles adding inviter to table `signuplinks`.
 */
class m160703_102329_add_inviter_to_signuplinks extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('signuplinks', 'inviter', $this->string()->notNull());
        $this->addForeignKey(
            'FK_signuplinks_user',
            'signuplinks', 'inviter',
            'user', 'email'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        // drops foreign key for table `signuplinks`
        $this->dropForeignKey(
            'FK_signuplinks_user',
            'signuplinks'
        );

        $this->dropColumn('signuplinks', 'inviter');
    }
}
