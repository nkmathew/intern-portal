<?php

use yii\db\Migration;

/**
 * Handles the creation for table `config`.
 */
class m160920_163236_create_config extends Migration
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

        $this->createTable('config', [
            'id' => $this->primaryKey(),
            'supervisor' => $this->string()->unique()->notNull(),
            // Whether the user can edit old entries
            'can_modify_later' => $this->boolean()->defaultValue(1),
            // Whether the intern can add a missed entry
            'can_add_later' => $this->boolean()->notNull()->defaultValue(1),
            'starting_hour' => $this->time()->defaultValue('08:00:00'),
            'closing_hour' => $this->time()->defaultValue('17:00:00')
        ], $tableOptions);

        $this->addForeignKey('FK-config_supervisor-user', 'config',
            'supervisor', 'user', 'email');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey('FK-config_supervisor-user', 'config');
        $this->dropTable('config');
    }
}
