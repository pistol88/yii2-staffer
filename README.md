Yii2-staffer
==========
Справочник сотрудников (только бекенд).

В состав входит возможность управлять (CRUD):

* Сотрудники (имя, фото, статус)
* Категории сотрудников

Установка
---------------------------------
Выполнить команду

```
php composer require pistol88/yii2-staffer "*"
```

Или добавить в composer.json

```
"pistol88/yii2-staffer": "*",
```

И выполнить

```
php composer update
```

Далее, мигрируем базу:

```
php yii migrate --migrationPath=vendor/pistol88/yii2-staffer/migrations
```

Не забываем выполнить миграцию модулуй, от которых зависит staffer

Настройка
---------------------------------

В секцию modules конфига добавить:

```
    'modules' => [
        //..
        'staffer' => [
            'class' => 'pistol88\staffer\Module',
            'adminRoles' => ['administrator'],
        ],
        //..
    ]
```

В секцию components:

```
        'staffer' => [
            'class' => 'pistol88\staffer\Staffer',
        ],
```

Использование
---------------------------------
* ?r=staffer/staffer/index - сотрудники
* ?r=staffer/category/index - категории

Виджеты
---------------------------------
Виджеты в разработке.
