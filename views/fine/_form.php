<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use pistol88\staffer\models\Staffer;
use kartik\select2\Select2;
?>

<div class="fine-form">

    <div class="row">
        <?php $form = ActiveForm::begin(['action' => ['/staffer/fine/create'], 'options' => ['enctype' => 'multipart/form-data']]); ?>

        <div class="col-md-6">
            <?= $form->field($model, 'staffer_id')
                ->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(Staffer::find()->all(), 'id', 'name'),
                    'language' => 'ru',
                    'options' => ['placeholder' => 'Выберите сотрудника ...'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]); ?>

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
        </div>

        <?php ActiveForm::end(); ?>
    </div>

</div>
