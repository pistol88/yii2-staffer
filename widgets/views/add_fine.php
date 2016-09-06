<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use pistol88\staffer\models\Staffer;
use kartik\select2\Select2;
?>
<div class="add-fine-widget">
    
    <?php Modal::begin([
        'header' => '<h2>Добавить</h2>',
        'toggleButton' => ['class' => 'btn btn-success', 'label' => 'Добавить'],
    ]);
    ?>

    <?php $form = ActiveForm::begin(['action' => ['/staffer/fine/ajax-create'], 'options' => ['enctype' => 'multipart/form-data']]); ?>
        <div class="col-md-6">
            <?= $form->field($model, 'reason')
                ->widget(Select2::classname(), [
                    'data' => $module->fineReasons,
                    'language' => 'ru',
                    'options' => ['placeholder' => 'Выберите причину ...'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]); ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'sum')->textInput() ?>

            <?= $form->field($model, 'comment')->textArea() ?>
        </div>

        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Изменить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            <?= $form->field($model, 'staffer_id')->label(false)->textInput(['value' => $staffer->id, 'type' => 'hidden']) ?>
        </div>
    <?php ActiveForm::end(); ?>
    
    <?php Modal::end(); ?>
    
    <?php Pjax::begin(); ?>

    <a href="" class="add-fine-update"> </a>
    <div class="summary">
        Всего:
        <?=number_format($dataProvider->query->sum('sum'), 2, ',', '.');?>
    </div>
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
                    }
                ],
                'sum',
                'comment',
                'created_at',
                ['class' => 'yii\grid\ActionColumn', 'template' => '{update} {delete}', 'controller' => '/staffer/fine', 'buttonOptions' => ['class' => 'btn btn-default'], 'options' => ['style' => 'width: 125px;']],
            ],
        ]); ?>
    <?php Pjax::end(); ?>
</div>