<?php
namespace pistol88\staffer\widgets;

use yii\helpers\Html;
use pistol88\staffer\models\Fine;
use pistol88\staffer\models\fine\FineSearch;
use kartik\select2\Select2;
use yii;

class AddFine extends \yii\base\Widget
{
    public $staffer = null;

    public function init()
    {
        \pistol88\staffer\assets\AddFineAsset::register($this->getView());

        return parent::init();
    }

    public function run()
    {
        $searchModel = new FineSearch();

        $params = Yii::$app->request->queryParams;

        if($this->staffer && empty($params['FineSearch'])) {
            $params['FineSearch']['staffer_id'] = $this->staffer->id;
        }

        $dataProvider = $searchModel->search($params);

        $model = new Fine;

        $userOnSession = false;
        if (\Yii::$app->has('worksess') && $session = yii::$app->worksess->soon()) {
            $sessionId = $session->id;
            $userOnSession = $session->getOpenedUserSessions()->andWhere(['user_id' => $this->staffer->id])->all();
        }

        return $this->render('add_fine', [
            'module' => yii::$app->getModule('staffer'),
            'model' => $model,
            'staffer' => $this->staffer,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'userOnSession' => $userOnSession,
        ]);
    }
}
