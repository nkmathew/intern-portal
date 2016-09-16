<?php

use yii\db\Migration;

/**
 * Handles the creation for table `supervisor_reviews`.
 */
class m160918_002058_create_supervisor_reviews extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('supervisor_reviews', [
            'id' => $this->primaryKey(),
            'reviewer' => $this->string(),
            'review' => $this->text(),
            'reviewed_intern' => $this->string(),
            'created' => $this->timestamp(),
        ], $tableOptions);

        $this->addForeignKey('FK_reviewed_intern_user-supervisor_reviews', 'supervisor_reviews',
          'reviewed_intern', 'user', 'email');

        $this->addForeignKey('FK_reviewer_user-supervisor_reviews', 'supervisor_reviews',
          'reviewer', 'user', 'email');

        $this->addForeignKey('FK_supervisor_review_reviews', 'logbook',
            'supervisor_review', 'supervisor_reviews', 'id');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey('FK_supervisor_review_reviews', 'logbook');
        $this->dropForeignKey('FK_reviewed_intern_user-supervisor_reviews', 'supervisor_reviews');
        $this->dropForeignKey('FK_reviewer_user-supervisor_reviews', 'supervisor_reviews');
        $this->dropTable('supervisor_reviews');
    }
}
