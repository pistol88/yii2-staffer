<?php
namespace pistol88\staffer\assets;

use yii\web\AssetBundle;

class WidgetAsset extends AssetBundle
{
    public $depends = [
        'yii\bootstrap\BootstrapPluginAsset',
    ];

    public $js = [
        'js/worker_salary.js',
    ];
    
    public function init()
    {
        $this->sourcePath = __DIR__ . '/../web';
        parent::init();
    }
}
