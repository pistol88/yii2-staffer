<?php

use yii\db\Schema;
use yii\db\Migration;

class m161024_133611_staffer_payment extends Migration
{
    public function safeUp()
    {
        $tableOptions = 'ENGINE=InnoDB';

        $this->createTable(
            '{{%staffer_payment}}',
            [
                'id'=> Schema::TYPE_PK."",
                'user_id'=> Schema::TYPE_INTEGER."(11) NOT NULL",
                'worker_id'=> Schema::TYPE_INTEGER."(11) NOT NULL",
                'sum'=> Schema::TYPE_DECIMAL."(11,2) NOT NULL",
                'session_id'=> Schema::TYPE_INTEGER."(11) NOT NULL",
                'date'=> Schema::TYPE_DATETIME." NOT NULL",
                'date_timestamp'=> Schema::TYPE_INTEGER."(11) NOT NULL",
                'type'=> "enum('in','out')"."",
                'client_id'=> Schema::TYPE_INTEGER."(11)",
                'order_id'=> Schema::TYPE_INTEGER."(11)",
                ],
            $tableOptions
        );

    }

    public function safeDown()
    {
        $this->dropTable('{{%staffer_payment}}');
    }
}
