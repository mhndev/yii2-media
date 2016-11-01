<?php

namespace mhndev\yii2Media\Components;

use Yii;
use mhndev\media\UploadFile;
use mhndev\yii2Media\Interfaces\iEntity;
use mhndev\yii2Media\Interfaces\iMedia;
use mhndev\yii2Media\Models\Media as MediaModel;

/**
 * Class Media
 * @package mhndev\yii2Media\Components
 */
class Media
{
    /**
     * @var array
     */
    protected static $config = [];

    /**
     * @var string
     */
    protected static $mediaClass = null;


    /**
     * @var string
     */
    protected static $userClass = null;


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
        if(!empty(self::$config)){
            return self::$config;
        }

        if (Yii::$app instanceof \yii\console\Application) {
            $config = include Yii::$aliases['@config'].DIRECTORY_SEPARATOR.'media_console.php';
        } else {
            $config = include Yii::$aliases['@config'].DIRECTORY_SEPARATOR.'media_web.php';
        }

        self::$mediaClass = $config['mediaClass'];
        self::$userClass = $config['userClass'];

        return $config;
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
                    'entity_id'=>$model->{$model->primaryKey()[0]},
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
                    'entity_id'=>$model->{$model->primaryKey()[0]},
                    'owner'=> $ownerClass,
                    'owner_id'=>$ownerId,
                    'link'=>null,
                    'type'=>$type
                ]);
            }
        }

        /** @var iEntity $model */
        return $model->attachMultipleMedia($data, false);
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
     * @return mixed
     */
    public static function markMediaAsDefaultByMediaId($media_id)
    {
        $mediaClass = self::mediaClass();

        /** @var iMedia $media */
        $media = $mediaClass::findOne($media_id);

        return $media->markAsDefault();
    }


    /**
     * @param $entity
     * @param $entities_id
     */
    public static function deleteBatch($entity, $entities_id)
    {
        MediaModel::deleteAll([['in', 'entity_id',$entities_id], ['entity'=>$entity]]);
    }

}
