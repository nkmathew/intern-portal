<?php

use yii\db\Migration;

/**
 * Handles adding entry_for to table `logbook`.
 */
class m160712_073327_add_entry_for_to_logbook extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('logbook', 'entry_for', $this->date()->unique()->notNull());
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('logbook', 'entry_for');
    }
}
