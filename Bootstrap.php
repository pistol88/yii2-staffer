<?php
namespace pistol88\staffer;

use yii\base\BootstrapInterface;
use yii;

class Bootstrap implements BootstrapInterface
{
    public function bootstrap($app)
    {
        if(empty($app->modules['gridview'])) {
            $app->setModule('gridview', [
                'class' => '\kartik\grid\Module',
            ]);
        }

        if(!$app->has('staffer')) {
            $app->set('staffer', [
                'class' => '\pistol88\staffer\Staffer',
            ]);
        }
    }
}