<?php
use yii\bootstrap\Nav;
?>
<div class="menu-container">
    <?= Nav::widget([
        'items' => [
            [
                'label' => 'Сотрудники',
                'url' => ['/staffer/staffer/index'],
            ],
            [
                'label' => 'Категории',
                'url' => ['/staffer/category/index'],
            ],
        ],
        'options' => ['class' =>'nav-pills'],
    ]); ?>
</div>