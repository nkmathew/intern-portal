<?php

use yii\db\Migration;

/**
 * Handles adding supervisor_review and coordinator_review to table `logbook`.
 */
class m160911_131510_add_entry_review_id_to_logbook extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('logbook', 'supervisor_review', $this->integer());
        $this->addColumn('logbook', 'coordinator_review', $this->integer());
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('logbook', 'supervisor_review');
        $this->dropColumn('logbook', 'coordinator_review');
    }
}
