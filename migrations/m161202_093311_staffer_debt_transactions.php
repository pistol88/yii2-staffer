<?php

use yii\db\Schema;
use yii\db\Migration;

class m161202_093311_staffer_debt_transactions extends Migration
{
    public function safeUp()
    {
        $tableOptions = 'ENGINE=InnoDB';

        $this->createTable(
            '{{%staffer_debt_transactions}}',
            [
                'id'=> Schema::TYPE_PK."",
                'worker_id'=> Schema::TYPE_INTEGER."(11) NOT NULL",
                'sum'=> Schema::TYPE_FLOAT."(12,2) NOT NULL",
                'date'=> Schema::TYPE_DATETIME." NOT NULL",
                'session_id'=> Schema::TYPE_INTEGER."(11)",
                'user_id'=> Schema::TYPE_INTEGER."(11) NOT NULL",
                'balance'=> Schema::TYPE_FLOAT."(12,2) NOT NULL",
                'type'=> "enum('given','return')"." NOT NULL",
                'delete'=> Schema::TYPE_DATETIME."",
                ],
            $tableOptions
        );

    }

    public function safeDown()
    {
        $this->dropTable('{{%staffer_debt_transactions}}');
    }
}
