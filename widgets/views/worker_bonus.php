<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;
?>
<div class="worker-bonus-widget">


    <div class="summary">
        <!-- Общая сумма аванса: <?php // $totalDebt ?> -->
    </div>
    <?php Pjax::begin(); ?>
    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'columns' => [
            // ['attribute' => 'id', 'filter' => false, 'options' => ['style' => 'width: 49px;']],
            [
                'attribute' => 'created',
                'value' => function($model) {
                    return  date('d.m.Y H:i:s', strtotime($model->created));
                }
            ],
            ['attribute' => 'sum', 'filter' => false, 'label' => 'Начислено'],
            [
                'attribute' => 'reason'
            ],
            [
                'format' => 'raw',
                'value' => function($model) {

                    if (is_null($model->canceled) && is_null($model->payed)) {

                        return '<div class="btn btn-default"
                                onclick="return confirm(\'Отменить начисление?\')"
                                data-url="'.Url::to(['/staffer/bonus/cancel-ajax"']).'"
                                data-id="'.$model->id.'"
                                data-role="cancel-bonus"
                                >отменить начисление</div>';
                    }

                    if (!is_null($model->canceled)) {
                        return 'отменена: '.date("Y.m.d H:i:s", strtotime($model->canceled));
                    }

                    if (!is_null($model->payed)) {
                        return 'начислена в зп: '.date("Y.m.d H:i:s", strtotime($model->payed));
                    }
                }
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
