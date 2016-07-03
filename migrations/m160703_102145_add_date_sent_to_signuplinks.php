<?php

use yii\db\Migration;

/**
 * Handles adding date_sent to table `signuplinks`.
 */
class m160703_102145_add_date_sent_to_signuplinks extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('signuplinks', 'date_sent', $this->integer()->notNull());
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('signuplinks', 'date_sent');
    }
}
