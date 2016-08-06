<?php
use yii\helpers\Html;
use yii\grid\GridView;

$this->title = Html::encode($model->name);
$this->params['breadcrumbs'][] = ['label' => 'Сотрудники', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Обновить';
?>
<div class="model-update">
    <?= $this->render('_form', [
        'model' => $model,
        'module' => $module,
    ]) ?>
    
    <?php if(class_exists('\pistol88\service\widgets\WorkerPayments')) { ?>
        <div class="block">
            <h2>Выплаты</h2>
            <?=\pistol88\service\widgets\WorkerPayments::widget(['worker_id' => $model->id]);?>
        </div>
    <?php } ?>
    
    <?php if($fieldPanel = \pistol88\field\widgets\Choice::widget(['model' => $model])) { ?>
        <div class="block">
            <h2>Прочее</h2>
            <?=$fieldPanel;?>
        </div>
    <?php } ?>
</div>
