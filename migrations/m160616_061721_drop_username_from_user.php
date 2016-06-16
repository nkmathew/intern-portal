<?php

use yii\db\Migration;

/**
 * Handles dropping username from table `user`.
 */
class m160616_061721_drop_username_from_user extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->dropColumn('user', 'username');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->addColumn('user', 'username', $this->integer());
    }
}
