<?php
namespace pistol88\staffer\models;

use Yii;
use yii\helpers\Url;
use pistol88\staffer\models\Category;
use pistol88\staffer\models\Price;
use pistol88\staffer\models\staffer\StafferQuery;
use yii\db\ActiveQuery;

class Staffer extends \yii\db\ActiveRecord
{
    function behaviors()
    {
        return [
            'images' => [
                'class' => 'pistol88\gallery\behaviors\AttachImages',
            ],
            'field' => [
                'class' => 'pistol88\field\behaviors\AttachFields',
            ],
            'session' => [
                'class' => 'pistol88\worksess\behaviors\AttachSession',
            ],
        ];
    }
    
    public static function tableName()
    {
        return '{{%staffer_staffer}}';
    }
    
    public static function Find()
    {
        $return = new StafferQuery(get_called_class());
        $return = $return->with('category');
        
        return $return;
    }
    
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['category_id', 'sort'], 'integer'],
            [['text', 'status'], 'string'],
            [['name'], 'string', 'max' => 200],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => 'Категория',
            'status' => 'Статус',
            'session' => 'Рабочая сессия',
            'name' => 'Название',
            'text' => 'Текст',
            'images' => 'Картинки',
            'image' => 'Фото',
            'sort' => 'Сортировка',
        ];
    }
    
    public function getId()
    {
        return $this->id;
    }
    
    public function getUsername() {
        return $this->name;
    }
    
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }
}
