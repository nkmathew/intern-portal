<?php

use yii\db\Migration;

/**
 * Handles the creation for table `profile`.
 */
class m160622_095150_create_profile extends Migration
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

        $this->createTable('profile', [
            'id' => $this->primaryKey(),
            'sex' => $this->string(),
        ]);
        $this->addForeignKey('FK_profile_user', 'profile', 'id', 'user', 'id');;
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        // drops foreign key for table `profile`
        $this->dropForeignKey(
            'FK_profile_user',
            'profile'
        );
        $this->dropTable('profile');
    }
}
