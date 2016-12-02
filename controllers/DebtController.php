<?php
namespace pistol88\staffer\controllers;

use Yii;
use pistol88\staffer\models\Payment;
use pistol88\staffer\models\category\PaymentSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

class DebtController extends Controller
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

        $stafferId = $data['stafferId'];
        $type = $data['type'];
        $sessionId = $data['sessionId'];
        $sum = $data['sum'];

        $debtId = Yii::$app->staffer->addDebtTransaction($stafferId, $sum, $sessionId, $type);

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if ($debtId) {
            return [
                'status' => 'success',
                'debtId' => $debtId
            ];
        } else {
            return [
                'status' => 'error'
            ];
        }
        
    }

    public function actionRemoveAjax()
    {
        $paymentId = (int)yii::$app->request->post('paymentId');

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        if ($paymentId = Yii::$app->staffer->removePayment($paymentId)) {
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
