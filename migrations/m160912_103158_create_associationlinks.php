<?php

use yii\db\Migration;

/**
 * Handles the creation for table `associationlinks`.
 */
class m160912_103158_create_associationlinks extends Migration
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
        $this->createTable('associationlinks', [
            'id' => $this->primaryKey(),
            'intern' => $this->string()->notNull(),
            'token' => $this->string()->notNull()->unique(),
            'date_sent' => $this->timestamp()->notNull(),
            'supervisor' => $this->string()->notNull(),
            'is_disabled' => $this->boolean()->defaultValue(0),
        ], $tableOptions);

        $this->addForeignKey('FK_associationlinks_user',
          'associationlinks', 'intern', 'user', 'email');

        $this->addForeignKey('FK_associationlinks_user_supervisor',
          'associationlinks', 'supervisor', 'user', 'email');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey('FK_associationlinks_user_supervisor', 'associationlinks');
        $this->dropForeignKey('FK_associationlinks_user', 'associationlinks');
        $this->dropTable('associationlinks');
    }
}
