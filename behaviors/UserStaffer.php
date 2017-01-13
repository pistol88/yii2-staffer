<?php
namespace pistol88\staffer\behaviors;

use yii;
use yii\base\Behavior;
use pistol88\staffer\models\Staffer;

class UserStaffer extends Behavior
{
    public function getStaffer()
    {
        $model = $this->owner;
        
        return Staffer::find()->where(['user_id' => $this->owner->id])->one();
    }
}
