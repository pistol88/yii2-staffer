<?php
namespace pistol88\staffer;

use yii;

class Module extends \yii\base\Module
{
    const EVENT_PAYMENT_CREATE = 'paymentCreate';
    const EVENT_PAYMENT_REMOVE = 'paymentRemove';

    public $adminRoles = ['admin', 'superadmin'];
    public $stafferStatuses = ['active' => 'Активный', 'dismissed' => 'Уволенный', 'missing' => 'Пропавший'];
    public $activeStatuses = ['active'];
    public $payTypes = ['base' => 'Базовый'];
    public $fineReasons = ['Опоздание', 'Не выход на работу', 'Некачественная работа'];
    public $registerUserCallback = null; //Callback функция регистрации сотрудника в системе
    public $userRoles = ['staffer', 'user', 'administrator', 'superadmin'];
    public $defaultRole = 'staffer';
    public $salaryCashbox = 1; // id зарплатной кассы

    public function init()
    {
        parent::init();
    }

    public function registerUser(models\Staffer $staffer)
    {
        if(is_callable($this->registerUserCallback)) {
            $registerUserCallback = $this->registerUserCallback;

            return $registerUserCallback($staffer);
        }

        return false;
    }
}
