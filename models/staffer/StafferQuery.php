<?php
namespace pistol88\staffer\models\staffer;

use pistol88\staffer\models\Category;
use yii\db\ActiveQuery;

class StafferQuery extends ActiveQuery
{
    public function category($childCategoriesIds)
    {
         return $this->andwhere(['category_id' => $childCategoriesIds]);
    }
}