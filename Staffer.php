<?php
namespace pistol88\staffer;

use yii\base\Component;
use pistol88\staffer\models\Staffer as StafferModel;
use yii;

class Staffer extends Component
{
    public $finder = null;
    
    public function init()
    {
        $this->finder = StafferModel::find();
        
        parent::init();
    }
    
    public function status($status)
    {
        $this->finder->andWhere(['status' => $status]);
        
        return $this;
    }

    public function all()
    {
        return $this->finder->all();
    }
    
    public function one()
    {
        return $this->finder->one();
    }
}
