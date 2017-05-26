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
            <a class="btn btn-default" href="<?=Url::toRoute(['staffer/delete', 'id' => $model->id]);?>" title="Удалить" aria-label="Удалить" data-confirm="Вы уверены, что хотите удалить этот элемент?" data-method="post" data-pjax="0"><span class="glyphicon glyphicon-trash"></span></a>
        <?php } ?>
    </div>
    
    <div class="row">
        <div class="col-md-3 col-xs-6">
            <?= $form->field($model, 'name')->textInput() ?>
        </div>
        <div class="col-md-3 col-xs-6">
            <?= $form->field($model, 'sort')->textInput() ?>
        </div>
        <div class="col-md-3 col-xs-6">
            <?= $form->field($model, 'pay_type')->dropDownList(yii::$app->getModule('staffer')->payTypes) ?>
        </div>
        <div class="col-md-3 col-xs-6">
            <?= $form->field($model, 'persent')->textInput(['type' => 'number']) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3 col-xs-6">
            <?= $form->field($model, 'fix')->textInput(['type' => 'number']) ?>
        </div>
        <div class="col-md-3 col-xs-6">
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
        <div class="col-md-3 col-xs-6">
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
        <div class="col-md-3 col-xs-6">
            <?= $form->field($model, 'user_id')->textInput(['type' => 'number']) ?>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-3 col-xs-6">
            <?php if(yii::$app->has('organization') && $organization = yii::$app->get('organization')) { ?>
                <?php echo $form->field($model, 'organization_id')->dropDownList(ArrayHelper::map($organization->getList(), 'id', 'name'), ['prompt' => 'Нет']) ?>
            <?php } ?>
        </div>
    </div>

    <?= $form->field($model, 'text')->textArea() ?>

    <?=Gallery::widget(['model' => $model]); ?>

    <br />
    
    <?php if(empty($model->user_id)) { ?>
        <h3>Создание пользователя</h3>
        <div class="row">
            <div class="col-md-3 col-xs-6">
                <div class="form-group field-user-name">
                    <label class="control-label" for="user-name">Логин</label>
                    <input type="text" id="user-name" class="form-control" name="user[login]" value="staffer<?=$model->id;?>" />
                </div>        
            </div>
            <div class="col-md-3 col-xs-6">
                <div class="form-group field-user-name">
                    <label class="control-label" for="user-password">Пароль</label>
                    <input type="text" id="user-password" class="form-control" name="user[password]" value="<?=substr(md5(rand(0, 9999999).'-'.rand(0, 999).$_SERVER['REMOTE_ADDR']), 0, 7);?>" />
                </div>        
            </div>
            <div class="col-md-3 col-xs-6">
                <div class="form-group field-user-name">
                    <label class="control-label" for="user-name">Полномочия</label>
                    <select name="user[roles][]" class="form-control" multiple>
                        <?php foreach(\Yii::$app->authManager->getRoles() as $roleId => $roleData) { ?>
                            <option value="<?=$roleId;?>" <?php if($roleId == yii::$app->getModule('client')->defaultRole) echo 'selected="selected"'; ?>><?=$roleId;?></option>
                        <?php } ?>
                    </select>
                </div>        
            </div>
        </div>
    <?php } ?>
    
    <div class="form-group staffer-control">
        <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?php if(!$model->isNewRecord) { ?>
            <a class="btn btn-default" href="<?=Url::toRoute(['staffer/delete', 'id' => $model->id]);?>" title="Удалить" aria-label="Удалить" data-confirm="Вы уверены, что хотите удалить этот элемент?" data-method="post" data-pjax="0"><span class="glyphicon glyphicon-trash"></span></a>
        <?php } ?>
    </div>

    <?php ActiveForm::end(); ?>
    
</div>
