<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use pistol88\staffer\models\Category;
use pistol88\gallery\widgets\Gallery;
use kartik\select2\Select2;

\pistol88\staffer\assets\BackendAsset::register($this);
?>

<div class="model-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    
    <div class="form-group staffer-control">
        <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        
            <?php if(!$model->isNewRecord) { ?>
            <a class="btn btn-default" href="<?=Url::toRoute(['model/delete', 'id' => $model->id]);?>" title="Удалить" aria-label="Удалить" data-confirm="Вы уверены, что хотите удалить этот элемент?" data-method="post" data-pjax="0"><span class="glyphicon glyphicon-trash"></span></a>
        <?php } ?>
    </div>
    
    <div class="row">
        <div class="col-md-3 col-xs-3">
            <?= $form->field($model, 'name')->textInput() ?>
        </div>
        <div class="col-md-3 col-xs-2">
            <?= $form->field($model, 'sort')->textInput() ?>
        </div>
        <div class="col-md-3 col-xs-2">
            <?= $form->field($model, 'pay_type')->dropDownList(yii::$app->getModule('staffer')->payTypes) ?>
        </div>
        <div class="col-md-3 col-xs-2">
            <?= $form->field($model, 'persent')->textInput(['type' => 'number']) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3">
            <?= $form->field($model, 'fix')->textInput(['type' => 'number']) ?>
        </div>
        <div class="col-md-3 col-xs-3">
            <?= $form->field($model, 'category_id')
                ->widget(Select2::classname(), [
                'data' => Category::buildTextTree(),
                'language' => 'ru',
                'options' => ['placeholder' => 'Выберите категорию ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]); ?>
        </div>
        <div class="col-md-3 col-xs-3">
            <?= $form->field($model, 'status')
                ->widget(Select2::classname(), [
                'data' => $module->stafferStatuses,
                'language' => 'ru',
                'options' => ['placeholder' => 'Выберите статус ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]); ?>
        </div>
    </div>

    <?= $form->field($model, 'text')->textArea() ?>

    <?php //Gallery::widget(['model' => $model]); ?>

    <div class="form-group staffer-control">
        <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?php if(!$model->isNewRecord) { ?>
            <a class="btn btn-default" href="<?=Url::toRoute(['model/delete', 'id' => $model->id]);?>" title="Удалить" aria-label="Удалить" data-confirm="Вы уверены, что хотите удалить этот элемент?" data-method="post" data-pjax="0"><span class="glyphicon glyphicon-trash"></span></a>
        <?php } ?>
    </div>

    <?php ActiveForm::end(); ?>
    
</div>
