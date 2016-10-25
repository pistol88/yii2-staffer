<?php
namespace pistol88\staffer\models;

use yii;
use pistol88\worksess\models\Session;
use pistol88\staffer\models\Staffer;

class Payment extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return '{{%staffer_payment}}';
    }

    public function rules()
    {
        return [
            [['worker_id', 'session_id', 'sum'], 'required'],
            [['user_id', 'worker_id', 'session_id', 'date_timestamp'], 'integer'],
            [['date'], 'string'],
            [['sum'], 'double'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'Администратор',
            'worker_id' => 'Сотрудник',
            'session_id' => 'Сессия',
            'date' => 'Дата',
            'date_timestamp' => 'Дата (таймстамп)',
            'sum' => 'Сумма',
        ];
    }

    public function getSession()
    {
        return $this->hasOne(Session::className(), ['id' => 'session_id']);
    }

    public function beforeSave($insert)
    {
        if(empty($this->user_id)) {
            $this->user_id = yii::$app->user->id;
        }

        if(empty($this->date)) {
            $this->date = date('Y-m-d H:i:s');
        }

        if(empty($this->date_timestamp)) {
            $this->date_timestamp = time();
        }

        return parent::beforeSave($insert);
    }

    public function getWorker()
    {
        return $this->hasOne(Staffer::className(), ['id' => 'worker_id']);
    }

}
