<?php
namespace pistol88\staffer\widgets;

use yii\helpers\Html;
use pistol88\staffer\models\Bonus;
use kartik\select2\Select2;
use yii;

class AddBonus extends \yii\base\Widget
{
    public $staffer = null;

    public function init()
    {
        \pistol88\staffer\assets\AddBonusAsset::register($this->getView());

        return parent::init();
    }



    public function run()
    {
        $model = new Bonus;

        $userOnSession = false;
        if (\Yii::$app->has('worksess') && $session = yii::$app->worksess->soon()) {
            $userOnSession = $session->getOpenedUserSessions()->andWhere(['user_id' => $this->staffer->id])->all();
        }

        if ($userOnSession) {
            return $this->render('add_bonus', [
                'module' => yii::$app->getModule('staffer'),
                'model' => $model,
                'staffer' => $this->staffer,
            ]);
        } else {
            return "<p>Не на смене</p>";
        }

    }
}
