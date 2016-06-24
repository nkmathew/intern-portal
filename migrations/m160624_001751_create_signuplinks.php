<?php

use yii\db\Migration;

/**
 * Handles the creation for table `signuplinks`.
 */
class m160624_001751_create_signuplinks extends Migration
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

        $this->createTable('signuplinks', [
            'id' => $this->primaryKey(),
            'email' => $this->string()->notNull(),
            'signup_token' => $this->string()->notNull()->unique(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('signuplinks');
    }
}
