<?php

use yii\db\Migration;

/**
 * Handles adding start_date to table `profile_table`.
 */
class m160710_010022_alter_start_date_to_date extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->alterColumn('profile', 'start_date', 'date');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->alterColumn('profile','start_date', 'integer');
    }
}
