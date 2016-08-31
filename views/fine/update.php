<?php
use yii\helpers\Html;

$this->title = 'Редактировать штраф: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Категории', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Редактирование';

?>
<div class="fine-update">

    <?= $this->render('_form', [
        'model' => $model,
        'module' => $module,
    ]) ?>
    
</div>
