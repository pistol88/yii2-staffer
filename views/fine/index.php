<?php
use pistol88\staffer\models\Staffer;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Штрафы';
$this->params['breadcrumbs'][] = $this->title;

\pistol88\staffer\assets\BackendAsset::register($this);
?>
<div class="fine-index">
    
    <div class="row">
        <div class="col-md-2">

        </div>
        <div class="col-md-10">
            <?=$this->render('../parts/menu');?>
        </div>
    </div>
    
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">Новый штраф</h3>
        </div>
        <div class="panel-body">
            <div class="col-md-6">
                <?php echo $this->render('_form', [
                    'model' => $model,
                    'module' => $module,
                ]) ?>
            </div>
        </div>
    </div>

    <br style="clear: both;"></div>

    <?=\kartik\grid\GridView::widget([
            'export' => false,
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                ['attribute' => 'id', 'filter' => false, 'options' => ['style' => 'width: 55px;']],
                [
                    'attribute' => 'reason',
                    'filter' => $module->fineReasons,
                    'content' => function($model) use ($module) {
                    return $module->fineReasons[$model->reason];
                }],
                'sum',
                'created_at',
                'comment',
                [
                    'attribute' => 'staffer_id',
                    'filter' => Html::activeDropDownList(
                        $searchModel,
                        'staffer_id',
                        ArrayHelper::map(Staffer::find()->all(), 'id', 'name'),
                        ['class' => 'form-control', 'prompt' => 'Сотрудник']
                    ),
                    'value' => 'staffer.name'
                ],
                ['class' => 'yii\grid\ActionColumn', 'template' => '{update} {delete}',  'buttonOptions' => ['class' => 'btn btn-default'], 'options' => ['style' => 'width: 125px;']],
            ],
        ]); ?>

</div>
