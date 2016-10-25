<?php
namespace pistol88\staffer\assets;

use yii\web\AssetBundle;

class AddPaymentAsset extends AssetBundle
{
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];

    public $js = [
        'js/add_payment.js',
    ];

    public $css = [
        'css/add_payment.css',
    ];

    public function init()
    {
        $this->sourcePath = __DIR__ . '/../web';
        parent::init();
    }
}
