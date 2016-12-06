<?php

namespace pistol88\staffer\models;

use Yii;
use pistol88\staffer\models\Staffer;

/**
 * This is the model class for table "staffer_bonus".
 *
 * @property integer $id
 * @property integer $staffer_id
 * @property string $reason
 * @property string $sum
 * @property string $comment
 * @property string $created
 * @property string $canceled
 */
class Bonus extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'staffer_bonus';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['staffer_id'], 'required'],
            [['staffer_id', 'user_id'], 'integer'],
            [['sum'], 'number'],
            [['created', 'canceled'], 'safe'],
            [['reason', 'comment'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'staffer_id' => 'ID Работника',
            'reason' => 'Причина',
            'sum' => 'Сумма',
            'comment' => 'Комментарий',
            'created' => 'Дата выплаты',
            'canceled' => 'Отмена',
            'user_id' => 'Пользователь'
        ];
    }

    public function getStaffer()
    {
        return $this->hasOne(Staffer::className(), ['id' => 'staffer_id']);
    }
}
