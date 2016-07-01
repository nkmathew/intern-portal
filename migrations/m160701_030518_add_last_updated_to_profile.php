<?php

use yii\db\Migration;

/**
 * Handles adding last_updated to table `profile`.
 */
class m160701_030518_add_last_updated_to_profile extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('profile', 'last_updated', $this->integer()->notNull());
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('profile', 'last_updated');
    }
}
