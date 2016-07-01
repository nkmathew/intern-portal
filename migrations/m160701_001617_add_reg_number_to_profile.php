<?php

use yii\db\Migration;

/**
 * Handles adding reg_number to table `profile`.
 */
class m160701_001617_add_reg_number_to_profile extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('profile', 'reg_number', $this->string(20));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('profile', 'reg_number');
    }
}
