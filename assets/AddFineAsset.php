<?php
namespace pistol88\staffer\assets;

use yii\web\AssetBundle;

class AddFineAsset extends AssetBundle
{
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];

    public $js = [
        'js/add_fine.js',
    ];
    
    public $css = [
        'css/add_fine.css',
    ];

    public function init()
    {
        $this->sourcePath = __DIR__ . '/../web';
        parent::init();
    }
}
