<?php
namespace pistol88\staffer\models;

use Yii;
use yii\helpers\Url;
use pistol88\staffer\models\Category;
use pistol88\staffer\models\Price;
use pistol88\staffer\models\staffer\StafferQuery;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\Expression;

class Staffer extends \yii\db\ActiveRecord
{
    function behaviors()
    {
        return [
            'images' => [
                'class' => 'pistol88\gallery\behaviors\AttachImages',
                'mode' => 'single',
            ],
            'field' => [
                'class' => 'pistol88\field\behaviors\AttachFields',
            ],
            'session' => [
                'class' => 'pistol88\worksess\behaviors\AttachSession',
            ],
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => new Expression('NOW()'),
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
            [['category_id', 'sort', 'persent', 'fix', 'user_id', 'organization_id'], 'integer'],
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
            'user_id' => 'ID пользователя',
            'text' => 'Текст',
            'images' => 'Картинки',
            'persent' => 'Индивидуальный процент',
            'fix' => 'Фикс',
            'image' => 'Фото',
            'sort' => 'Сортировка',
            'organization_id' => 'Организация',
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
    
    public function getUser()
    {
        $userModel = yii::$app->user->identityClass;
        
        return $userModel::find()->where(['id' => $this->user_id]);
    }
    
    public function setSalary($sessionId, $charged, $salary, $fines = 0, $bonuses = 0)
    {
        $salaryModel = new Salary;
        $salaryModel->worker_id = $this->id;
        $salaryModel->session_id = $sessionId;
        $salaryModel->fix = $this->fix;
        $salaryModel->charged = $charged;
        $salaryModel->fines = $fines;
        $salaryModel->bonuses = $bonuses;
        $salaryModel->salary = $salary;
        $salaryModel->date = date('Y-m-d H:i:s');
        $salaryModel->date_timestamp = time();

        return $salaryModel->save();
    }
    
    public function getSalary()
    {
        return $this->hasMany(Salary::className(), ['worker_id' => 'id']);
    }
    
    public function getSalaryBySessionId($sessionId)
    {
        if($salary = $this->getSalary()->where(['session_id' => $sessionId])->count()) {
            return $this->getSalary()->where(['session_id' => $sessionId])->sum('salary');
        }
        
        return 0;
    }
    
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    public function afterSave($insert, $changedAttributes){
        parent::afterSave($insert, $changedAttributes);
     
        if(empty($this->user_id) && $userId = yii::$app->getModule('staffer')->registerUser($this)) {
            $this->user_id = $userId;
            $this->save(false);
        }
    }
    
    public function getEmail()
    {
        return null;
    }
    
    public function getAvatar()
    {
        return null;
    }
}
