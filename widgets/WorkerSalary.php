<?php
namespace pistol88\staffer\widgets;

use yii\helpers\Html;
use pistol88\staffer\models\Payment;
use pistol88\staffer\models\payment\PaymentSearch;
use yii\data\ActiveDataProvider;
use yii;

class WorkerSalary extends \yii\base\Widget
{
    public $worker = null;

    public function init()
    {
        \pistol88\staffer\assets\WidgetAsset::register($this->getView());

        return parent::init();
    }

    public function run()
    {
        $sessionsQuery = $this->worker->getSalary();

        if(\Yii::$app->request->get('date_start') && \Yii::$app->request->get('date_start') == \Yii::$app->request->get('date_stop')) {
            $sessionsQuery->andWhere(['DATE_FORMAT(date, "%Y-%m-%d")' => date('Y-m-d', strtotime(\Yii::$app->request->get('date_start')))]);
        } else {
            if ($dateStart = \Yii::$app->request->get('date_start')) {
                $sessionsQuery->andWhere(['>=', 'DATE_FORMAT(date, "%Y-%m-%d")', date('Y-m-d', strtotime($dateStart))]);
            }

            if ($dateStop = \Yii::$app->request->get('date_stop')) {
                $sessionsQuery->andWhere(['<=', 'DATE_FORMAT(date, "%Y-%m-%d")', date('Y-m-d', strtotime($dateStop))]);
            }
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $sessionsQuery,
            'sort' => ['defaultOrder'=> ['id' => SORT_DESC]],
            'pagination' => [
                'pageSize' => 50,
            ],

        ]);

        return $this->render('worker_salary', [
            'dataProvider' => $dataProvider,
            'worker' => $this->worker
        ]);
    }
}
