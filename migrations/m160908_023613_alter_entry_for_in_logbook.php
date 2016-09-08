<?php

use yii\db\Migration;

class m160908_023613_alter_entry_for_in_logbook extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        // remove the unique index
        $this->dropIndex('entry_for', 'logbook');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        // add the unique index again
        $this->createIndex('entry_for', 'logbook', 'entry_for', $unique = true);
    }
}
