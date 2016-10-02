Yii2 Media Manipulation Module
==============================
media manipulation implementation in Yii2


## Installation
The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
composer require --prefer-dist mhndev/yii2-media "0.*"
```

or add

```
"mhndev/yii2-media": "0.*"
```
to the require section of your `composer.json` file.

Introduction 
------------


This package helps you manipulate any kind of media (image , video, text, pdf, ...) for any kind of entity you like.
for example consider you have a Post Entity , first of all you should use EntityTrait in your model just like following :

```php
namespace app\models;

use mhndev\yii2Media\Interfaces\iEntity;
use mhndev\yii2Media\Traits\EntityTrait;
use yii\db\ActiveRecord;

/**
 * Class Post
 * @package app\models
 */
class Post extends ActiveRecord implements iEntity
{

    use EntityTrait;

    /**
     * @return string
     */
    public static function tableName()
    {
        return 'posts';
    }



}

```


this package also helps you upload media and specify max upload size for any kind of media and mime types
and also you can specify this package log if memory directory size which you upload file is less than x MB.

create a config file called media like follow :
```php
<?php
return [
    'mediaClass' => \mhndev\yii2Media\Models\Media::class,


    'userClass' => \app\modules\user\models\User::class,

    'formats' => [


        'image'=>[
            'avatar'=>[
                'storagePath'=> Yii::getAlias('@webroot').DIRECTORY_SEPARATOR.'avatar',
                'uploadSizeLimit' => 2,
            ],

            'post-cover' => [
                'storagePath' => Yii::getAlias('@webroot').DIRECTORY_SEPARATOR.'post/cover',
                'uploadSizeLimit' => 3
            ],


            'cover' => [
                'storagePath' => Yii::getAlias('@webroot').DIRECTORY_SEPARATOR.'cover',
                'uploadSizeLimit' => 3
            ],

            'post-list-view' => [
                'storagePath' => Yii::getAlias('@webroot').DIRECTORY_SEPARATOR.'post/list',
                'uploadSizeLimit' => 4
            ]
        ],

        'audio'=>[
            'music'=>[
                'storagePath'=> Yii::getAlias('@webroot').DIRECTORY_SEPARATOR.'music',
                'uploadSizeLimit' => 10

            ],
            'english-learning'=>[
                'storagePath'=> Yii::getAlias('@webroot').DIRECTORY_SEPARATOR.'english-learning',
                'uploadSizeLimit' => 4

            ]
        ],

        'video'=>[
            'storagePath'=> Yii::getAlias('@webroot').DIRECTORY_SEPARATOR.'video',
            'uploadSizeLimit' => 10
        ],


        'text'=>[

            'document'=>[
                'storagePath'=> Yii::getAlias('@webroot').DIRECTORY_SEPARATOR.'text',
                'uploadSizeLimit' => 1
            ]
        ],

    ],


    'min_storage' => 100


];


```

#### This Package comes with a Media Controller which has following actions.

##### actionDefaultMedia
this action takes an media Id and set it as default media.

```php
    /**
     * @param string $media_id
     * @return mixed
     */
    public static function markMediaAsDefaultByMediaId($media_id)
    {
        $mediaClass = self::mediaClass();

        /** @var iMedia $media */
        $media = $mediaClass::findOne($media_id);

        return $media->markAsDefault();
    }
```

##### actionUploadAndAttachMedia
this action takes multiple file as input file upload and attach to specified entity.

```php
    /**
     * @return array|string
     */
    public function actionUploadAndAttachMedia()
    {
        $data = Yii::$app->request->post();
        $model = $data['entity']::findOne($data['entity_id']);

        return ['records'=>Media::storeAndAttach('media', $data['type'], $model)];
    }
```

this is action code and you can see exactly what it does.
