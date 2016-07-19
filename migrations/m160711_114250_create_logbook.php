<?php

use yii\db\Migration;

/**
 * Handles the creation for table `logbook`.
 */
class m160711_114250_create_logbook extends Migration
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

        $this->createTable('logbook', [
            'id' => $this->primaryKey(),
            'entry' => $this->text(),
            'updated' => $this->bigInteger(),
            'created' => $this->bigInteger(),
            'author' => $this->string()->notNull(),
        ], $tableOptions);

        $this->addForeignKey('FK_logbook_user', 'logbook', 'author', 'user', 'email');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        // drops foreign key for table `profile`
        $this->dropForeignKey(
            'FK_logbook_user',
            'logbook'
        );

        $this->dropTable('logbook');
    }
}
