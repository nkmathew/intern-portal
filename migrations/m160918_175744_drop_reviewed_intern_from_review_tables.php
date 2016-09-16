<?php

use yii\db\Migration;

/**
 * Handles dropping reviewed_intern from table `review_tables`.
 */
class m160918_175744_drop_reviewed_intern_from_review_tables extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->dropForeignKey('FK_reviewed_intern_user-supervisor_reviews', 'supervisor_reviews');
        $this->dropForeignKey('FK_reviewed_intern_user', 'coordinator_reviews');

        $this->dropColumn('supervisor_reviews', 'reviewed_intern');
        $this->dropColumn('coordinator_reviews', 'reviewed_intern');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->addColumn('supervisor_reviews', 'reviewed_intern', $this->string());
        $this->addColumn('coordinator_reviews', 'reviewed_intern', $this->string());

        $this->addForeignKey('FK_reviewed_intern_user-supervisor_reviews', 'supervisor_reviews',
            'reviewed_intern', 'user', 'email');

        $this->addForeignKey('FK_reviewed_intern_user', 'coordinator_reviews',
            'reviewed_intern', 'user', 'email');
    }
}
