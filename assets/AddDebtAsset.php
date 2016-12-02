<?php
namespace pistol88\staffer\assets;

use yii\web\AssetBundle;

class AddDebtAsset extends AssetBundle
{
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];

    public $js = [
        'js/add_debt.js',
    ];

    // public $css = [
    //     'css/add_fine.css',
    // ];

    public function init()
    {
        $this->sourcePath = __DIR__ . '/../web';
        parent::init();
    }
}
