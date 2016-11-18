<?php
namespace pistol88\staffer\models;

use yii;
use pistol88\worksess\models\Session;
use pistol88\staffer\models\Staffer;

class Salary extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return '{{%staffer_salary}}';
    }

    public function rules()
    {
        return [
            [['worker_id', 'session_id', 'date', 'salary', 'charged'], 'required'],
            [['worker_id', 'session_id', 'date_timestamp'], 'integer'],
            [['date'], 'string'],
            //[['charged', 'salary', 'bonuses', 'fines', 'fix', 'charged'], 'double'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'worker_id' => 'Сотрудник',
            'session_id' => 'Сессия',
            'date' => 'Дата',
            'date_timestamp' => 'Дата (таймстамп)',
            'charged' => 'Начислено',
            'salary' => 'К выплате',
            'bonuses' => 'Бонусы',
            'fines' => 'Штрафы',
            'fix' => 'Фикс',
        ];
    }

    public function getSession()
    {
        return $this->hasOne(Session::className(), ['id' => 'session_id']);
    }

    public function getWorker()
    {
        return $this->hasOne(Staffer::className(), ['id' => 'worker_id']);
    }
}
