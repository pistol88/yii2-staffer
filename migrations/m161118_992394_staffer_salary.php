<?php

use yii\db\Schema;
use yii\db\Migration;

class m161118_992394_staffer_salary extends Migration
{
    public function safeUp()
    {
        $tableOptions = 'ENGINE=InnoDB';

        $this->createTable(
            '{{%staffer_salary}}',
            [
                'id'=> Schema::TYPE_PK."",
                'worker_id'=> Schema::TYPE_INTEGER."(11) NOT NULL",
                'session_id'=> Schema::TYPE_INTEGER."(11)",
                'date'=> Schema::TYPE_DATETIME." NOT NULL",
                'date_timestamp'=> Schema::TYPE_INTEGER."(11) NOT NULL",
                'charged'=> Schema::TYPE_DECIMAL."(11,2) NOT NULL",
                'fines'=> Schema::TYPE_DECIMAL."(11,2)",
                'bonuses'=> Schema::TYPE_DECIMAL."(11,2)",
                'fix'=> Schema::TYPE_DECIMAL."(11,2)",
                'salary'=> Schema::TYPE_DECIMAL."(11,2)",
            ],
            $tableOptions
        );

    }

    public function safeDown()
    {
        $this->dropTable('{{%staffer_salary}}');
    }
}
