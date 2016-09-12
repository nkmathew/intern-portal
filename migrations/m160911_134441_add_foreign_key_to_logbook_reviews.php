<?php

use yii\db\Migration;

/**
 * Handles adding foreign_key to table `logbook_reviews`.
 */
class m160911_134441_add_foreign_key_to_logbook_reviews extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addForeignKey('FK_supervisor_review_reviews', 'logbook',
            'supervisor_review', 'reviews', 'id');

        $this->addForeignKey('FK_coordinator_review_reviews', 'logbook',
            'coordinator_review', 'reviews', 'id');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey('FK_supervisor_review_reviews', 'reviews');
        $this->dropForeignKey('FK_coordinator_review_reviews', 'reviews');
    }
}
