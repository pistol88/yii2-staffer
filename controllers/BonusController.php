<?php
namespace pistol88\staffer\controllers;

use Yii;
use pistol88\staffer\models\Bonus;
use pistol88\staffer\models\category\BonusSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

class BonusController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'add' => ['post', 'get'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
				'only' => ['add-ajax', 'remove-ajax'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => $this->module->adminRoles,
                    ]
                ]
            ],
        ];
    }

    public function actionIndex()
    {
        echo "index";
    }

    public function actionAddAjax()
    {
        $data = yii::$app->request->post();

        if (!$data) {
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return [
                'status' => 'error',
                'message' => 'no data'
            ];
        }

        $stafferId = $data['stafferId'];
        $sum = $data['sum'];
        $reason = $data['reason'];

        $bonusId = Yii::$app->staffer->addBonus($stafferId, $sum, $reason);

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if ($bonusId) {
            return [
                'status' => 'success',
                'bonusId' => $bonusId
            ];
        } else {
            return [
                'status' => 'error'
            ];
        }

    }

    public function actionCancelAjax()
    {
        $bonusId = (int)yii::$app->request->post('bonusId');

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        if ($paymentId = Yii::$app->staffer->cancelBonus($bonusId)) {
            return [
                'status' => 'success'
            ];
        } else {
            return [
                'status' => 'error'
            ];
        }

    }

}
