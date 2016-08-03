<?php

use yii\db\Schema;
use yii\db\Migration;

class m160728_081813_Mass extends Migration {

    public function safeUp() {
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        else {
            $tableOptions = null;
        }
        
        $connection = Yii::$app->db;

        try {
            $this->createTable('{{%staffer_staffer}}', [
                'id' => Schema::TYPE_PK . "",
                'category_id' => Schema::TYPE_INTEGER . "(10) NOT NULL",
                'name' => Schema::TYPE_STRING . "(200) NOT NULL",
                'text' => Schema::TYPE_TEXT . " NOT NULL",
                'pay_type' => Schema::TYPE_STRING . "(55) NOT NULL",
                'sort' => Schema::TYPE_INTEGER . "(11)",
                'status' => Schema::TYPE_STRING . "(55)",
                ], $tableOptions);

            $this->createIndex('category_id', '{{%staffer_staffer}}', 'category_id', 0);
            $this->createTable('{{%staffer_category}}', [
                'id' => Schema::TYPE_PK . "",
                'parent_id' => Schema::TYPE_INTEGER . "(11)",
                'name' => Schema::TYPE_STRING . "(55) NOT NULL",
                'text' => Schema::TYPE_TEXT . "",
                'sort' => Schema::TYPE_INTEGER . "(11)",
                ], $tableOptions);

            $this->createIndex('id', '{{%staffer_category}}', 'id,parent_id', 0);
            
            $this->addForeignKey(
                'fk_category_id', '{{%staffer_staffer}}', 'category_id', '{{%staffer_category}}', 'id', 'CASCADE', 'CASCADE'
            );
        } catch (Exception $e) {
            echo 'Catch Exception ' . $e->getMessage() . ' ';
        }
    }

    public function safeDown() {
        $connection = Yii::$app->db;
        try {
            $this->dropTable('{{%staffer_staffer}}');
            $this->dropTable('{{%staffer_category}}');
        } catch (Exception $e) {
            echo 'Catch Exception ' . $e->getMessage() . ' ';
            $transaction->rollBack();
        }
    }

}
