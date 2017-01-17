<?php
namespace pistol88\staffer\controllers;

use yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use pistol88\staffer\models\Staffer;
use yii\filters\VerbFilter;

class ToolsController  extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => $this->module->adminRoles,
                    ]
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'get-staffers-by-name' => ['post'],
                ],
            ],
        ];
    }
    
    public function actionGetStaffersByName()
    {
        $return = ['result' => 'success', 'elements' => []];
        $str = yii::$app->request->post('str');
        $staffers = Staffer::find()->where(['status' => 'active'])->andFilterWhere(['LIKE', 'name', $str])->limit(50)->all();
        
        foreach($staffers as $staffer) {
            if($staffer->category) {
                $categoryName = $staffer->category->name;
            } else {
                $categoryName = '';
            }
            
            $return['elements'][$staffer->id] = [
                'name' => $staffer->name,
                'category' => $categoryName,
                'id' => $staffer->id,
            ];
        }
        
        return json_encode($return);
    }
}
