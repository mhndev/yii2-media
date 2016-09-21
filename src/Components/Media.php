<?php

namespace mhndev\yii2Media\Components;

use mhndev\media\UploadFile;
use mhndev\yii2Media\Interfaces\iEntity;
use mhndev\yii2Media\Interfaces\iMedia;
use Yii;

/**
 * Class Media
 * @package mhndev\yii2Media\Components
 */
class Media
{
    /**
     * @var array
     */
    protected static $config;

    /**
     * @var string
     */
    protected static $mediaClass;


    /**
     * @var string
     */
    protected static $userClass;


    /**
     * @return mixed
     */
    protected static function mediaClass()
    {
        return self::config()['mediaClass'];
    }

    /**
     * @return mixed
     */
    protected static function userClass()
    {
        return self::config()['userClass'];
    }

    /**
     * @return array
     */
    public static function config()
    {
        if(self::$config)
            return self::$config;

        $config = include Yii::$aliases['@config'].DIRECTORY_SEPARATOR.'media.php';

        self::$mediaClass = $config['mediaClass'];
        self::$userClass = $config['userClass'];
    }


    /**
     * @param $inputName
     * @param $type
     * @param $model
     * @param bool $ownerLoggedInUser
     * @param $ownerClass
     * @param $ownerId
     * @return array|string
     * @throws \Exception
     */
    public static function storeAndAttach($inputName, $type, $model, $ownerLoggedInUser = true, $ownerClass = null, $ownerId = null)
    {

        if(! $model instanceof iEntity){
            throw new \Exception('Model should be instance of '.iEntity::class);
        }

        UploadFile::config(self::config());

        $return = UploadFile::store($inputName, $type);


        $data = [];

        if($ownerLoggedInUser){

            foreach ($return as $item) {
                $item['size'] = (float) $item['size'];
                $data[] = array_merge($item, [
                    'entity'=>get_class($model),
                    'entity_id'=>$model->{$model->primaryKey()},
                    'owner'=> self::userClass(),
                    'owner_id'=>Yii::$app->user->identity->id,
                    'link'=>null,
                    'type'=>$type
                ]);
            }

        }

        else{
            foreach ($return as $item) {
                $item['size'] = (float) $item['size'];
                $data[] = array_merge($item, [
                    'entity'=>get_class($model),
                    'entity_id'=>$model->{$model->primaryKey()},
                    'owner'=> $ownerClass,
                    'owner_id'=>$ownerId,
                    'link'=>null,
                    'type'=>$type
                ]);
            }
        }



        /** @var iEntity $model */
        $model->attachMultipleMedia($data, false);
    }

    /**
     * @param iMedia $media
     * @return mixed
     */
    public static function markMediaAsDefault(iMedia $media)
    {
        return $media->markAsDefault();
    }


    /**
     * @param string $media_id
     */
    public static function markMediaAsDefaultByMediaId($media_id)
    {
        /** @var iMedia $media */
        $media = self::mediaClass()->findOne($media_id);

        $media->markAsDefault();
    }


}
