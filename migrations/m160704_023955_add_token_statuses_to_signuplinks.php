<?php

use yii\db\Migration;

/**
 * Handles adding token_statuses to table `signuplinks`.
 */
class m160704_023955_add_token_statuses_to_signuplinks extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        // A token is disabled when the user signs up using some other token
        $this->addColumn('signuplinks', 'token_disabled', $this->boolean()->defaultValue(false));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('signuplinks', 'token_disabled');
    }
}
