<?php
namespace pistol88\staffer\assets;

use yii\web\AssetBundle;

class AddBonusAsset extends AssetBundle
{
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];

    public $js = [
        'js/add_bonus.js',
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
