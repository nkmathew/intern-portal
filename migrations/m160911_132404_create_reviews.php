<?php

use yii\db\Migration;

/**
 * Handles the creation for table `reviews`.
 */
class m160911_132404_create_reviews extends Migration
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
        $this->createTable('reviews', [
            'id' => $this->primaryKey(),
            'reviewer' => $this->string(),
            'review' => $this->text(),
            'reviewed_intern' => $this->string(),
            'created' => $this->timestamp(),
        ], $tableOptions);

        $this->addForeignKey('FK_reviewed_intern_user', 'reviews',
          'reviewed_intern', 'user', 'email');

        $this->addForeignKey('FK_reviewer_user', 'reviews',
          'reviewer', 'user', 'email');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey('FK_reviewed_intern_user', 'reviews');
        $this->dropForeignKey('FK_reviewer_user', 'reviews');
        $this->dropTable('reviews');
    }
}
