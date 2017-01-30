<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
?>

<div class="category-form">

    <h1><?=$model->staffer->name;?></h1>
    <p>Начислено: <?=$model->salary;?></p>
    
    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-3">
            <?= $form->field($model, 'charged')->textInput() ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'fix')->textInput() ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'fines')->textInput() ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'bonuses')->textInput() ?>
        </div>
    </div>
    
    <?= $form->field($model, 'session_id')->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'worker_id')->hiddenInput()->label(false) ?>
    
    <?= $form->field($model, 'date')->hiddenInput()->label(false) ?>
    
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Изменить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
