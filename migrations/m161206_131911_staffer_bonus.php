<?php

use yii\db\Schema;
use yii\db\Migration;

class m161206_131911_staffer_bonus extends Migration
{
    public function safeUp()
    {
        $tableOptions = 'ENGINE=InnoDB';

        $this->createTable(
            '{{%staffer_bonus}}',
            [
                'id'=> Schema::TYPE_PK."",
                'staffer_id'=> Schema::TYPE_INTEGER."(11) NOT NULL",
                'reason'=> Schema::TYPE_STRING."(255)",
                'sum'=> Schema::TYPE_DECIMAL."(11,2)",
                'comment'=> Schema::TYPE_STRING."(255)",
                'created'=> Schema::TYPE_DATETIME."",
                'canceled'=> Schema::TYPE_DATETIME."",
                'user_id'=> Schema::TYPE_INTEGER."(11) NOT NULL",
                ],
            $tableOptions
        );

    }

    public function safeDown()
    {
        $this->dropTable('{{%staffer_bonus}}');
    }
}
