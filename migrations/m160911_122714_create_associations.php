<?php

use yii\db\Migration;

/**
 * Handles the creation for table `associations`.
 */
class m160911_122714_create_associations extends Migration
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

        $this->createTable('associations', [
            'id' => $this->primaryKey(),
            'intern' => $this->string()->unique(),
            'supervisor' => $this->string(),
            'coordinator' => $this->string(),
        ], $tableOptions);

        $this->addForeignKey(
          'FK_associations_user_intern', 'associations',
          'intern', 'user', 'email');
        $this->addForeignKey(
          'FK_associations_user_supervisor', 'associations',
          'supervisor', 'user', 'email');
        $this->addForeignKey(
          'FK_associations_user_coordinator', 'associations',
          'coordinator', 'user', 'email');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey('FK_associations_user_intern', 'associations');
        $this->dropForeignKey('FK_associations_user_supervisor', 'associations');
        $this->dropForeignKey('FK_associations_user_coordinator', 'associations');

        $this->dropTable('associations');
    }
}
