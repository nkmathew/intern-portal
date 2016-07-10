<?php

use yii\db\Migration;

/**
 * Handles adding start_date to table `profile_table`.
 */
class m160709_232111_add_start_date_to_profile_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('profile', 'start_date', $this->integer());
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('profile', 'start_date');
    }
}
