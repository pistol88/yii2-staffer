<?php

use yii\db\Migration;

class m161110_050320_create_organisation_fields extends Migration
{
    public function up()
    {
        $this->addColumn('{{%staffer_staffer}}', 'organisation_id', $this->integer());
    }

    public function down()
    {
        $this->dropColumn('{{%staffer_staffer}}', 'organisation_id');
        
        return true;
    }
}
