<?php
namespace pistol88\staffer\models;

use Yii;
use yii\helpers\Url;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use pistol88\staffer\models\Staffer;


class Fine extends \yii\db\ActiveRecord
{
    function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    public static function tableName()
    {
        return '{{%staffer_fine}}';
    }

    public function rules()
    {
        return [
            [['reason', 'staffer_id'], 'required'],
            [['staffer_id'], 'integer'],
            [['reason', 'comment', 'created_at', 'updated_at'], 'string'],
            [['sum'], 'double'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'reason' => 'Причина',
            'staffer_id' => 'Сотрудник',
            'comment' => 'Комментарий',
            'created_at' => 'Дата',
            'updated_at' => 'Дата редактирования',
            'sum' => 'Сумма штрафа',
        ];
    }

    public function getStaffer()
    {
        return $this->hasOne(Staffer::className(), ['id' => 'staffer_id']);
    }
}
