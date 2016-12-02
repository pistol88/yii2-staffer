<?php
namespace pistol88\staffer\models;

use Yii;

/**
 * This is the model class for table "staffer_debt_transactions".
 *
 * @property integer $id
 * @property integer $staffer_id
 * @property double $sum
 * @property string $date
 * @property integer $session_id
 * @property integer $user_id
 * @property double $balance
 * @property string $type
 * @property string $delete
 */
class DebtTransactions extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'staffer_debt_transactions';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['worker_id', 'sum', 'type'], 'required'],
            [['worker_id', 'session_id', 'user_id'], 'integer'],
            [['sum', 'balance'], 'number'],
            [['date', 'delete'], 'safe'],
            [['type'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'worker_id' => 'Staffer ID',
            'sum' => 'Sum',
            'date' => 'Date',
            'session_id' => 'Session ID',
            'user_id' => 'User ID',
            'balance' => 'Долг',
            'type' => 'Type',
            'delete' => 'Delete',
        ];
    }

    public function getWorker()
    {
        return $this->hasOne(Staffer::className(), ['id' => 'worker_id']);
    }

}
