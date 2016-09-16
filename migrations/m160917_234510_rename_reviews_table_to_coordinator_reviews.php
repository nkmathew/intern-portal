<?php

use yii\db\Migration;

/**
 * Handles the creation for table `coordinator_reviews`.
 */
class m160917_234510_rename_reviews_table_to_coordinator_reviews extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->dropForeignKey('FK_supervisor_review_reviews', 'logbook');
        // $this->dropForeignKey('FK_coordinator_review_reviews', 'logbook');

        $this->renameTable('reviews', 'coordinator_reviews');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->renameTable('coordinator_reviews', 'reviews');
        // $this->renameTable('reviews', 'coordinator_reviews');

        $this->addForeignKey('FK_supervisor_review_reviews',
            'logbook', 'supervisor_review', 'reviews', 'id');

        // $this->addForeignKey('FK_coordinator_review_reviews',
        //     'logbook', 'coordinator_review', 'reviews', 'id');
    }
}
