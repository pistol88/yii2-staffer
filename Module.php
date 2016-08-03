<?php
namespace pistol88\staffer;

use yii;

class Module extends \yii\base\Module
{
    public $adminRoles = ['admin', 'superadmin'];
    public $stafferStatuses = ['active' => 'Активный', 'dismissed' => 'Уволенный', 'missing' => 'Пропавший'];
    public $activeStatuses = ['active'];
    public $payTypes = ['base' => 'Базовый'];
    
    public function init()
    {
        parent::init();
    }
}