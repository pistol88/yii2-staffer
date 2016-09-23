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
            [['category_id', 'sort', 'persent', 'fix'], 'integer'],
            [['text', 'status', 'pay_type'], 'string'],
            [['name'], 'string', 'max' => 200],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => 'Категория',
            'status' => 'Статус',
            'pay_type' => 'Тип выплат',
            'session' => 'Рабочая сессия',
            'name' => 'Имя',
            'text' => 'Текст',
            'images' => 'Картинки',
            'persent' => 'Индивидуальный процент',
            'fix' => 'Фикс',
            'image' => 'Фото',
            'sort' => 'Сортировка',
        ];
    }
    
    public function getFines($where = false)
    {
        return $this->hasMany(Fine::className(), ['staffer_id' => 'id']);
    }
    
    public function getFinesByDatePeriod($dateStart, $dateStop)
    {
        if($dateStop == '0000-00-00 00:00:00' | empty($dateStop)) {
            $dateStop = date('Y-m-d H:i:s');
        }
        
        return $this->getFines()->where('created_at > :start AND created_at < :stop', [':start' => $dateStart, ':stop' => $dateStop]);
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
