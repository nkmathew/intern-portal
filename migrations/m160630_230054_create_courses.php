<?php

use yii\db\Migration;

/**
 * Handles the creation for table `courses`.
 */
class m160630_230054_create_courses extends Migration
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

        $this->createTable('courses', [
            'id' => $this->primaryKey(),
            'course_code' => $this->string()->notNull()->unique(),
            'course_name' => $this->string()->notNull(),
            'duration' => $this->integer(),
            'stage_caption' => $this->string(),
        ], $tableOptions);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('courses');
    }
}
