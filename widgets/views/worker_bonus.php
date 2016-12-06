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
            ]
            // [
            //     'attribute' => 'user_id'
            // ]
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
