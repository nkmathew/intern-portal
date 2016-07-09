<?php

use yii\db\Migration;

/**
 * Handles adding duration_column to table `profile_table`.
 */
class m160709_223459_add_duration_column_to_profile_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('profile', 'duration', $this->integer());
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('profile', 'duration');
    }
}
