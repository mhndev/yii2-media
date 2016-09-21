<?php

namespace mhndev\yii2Media\Components;

use mhndev\media\UploadFile;
use mhndev\yii2Media\Interfaces\iEntity;
use Yii;

/**
 * Class Media
 * @package mhndev\yii2Media\Components
 */
class Media
{


    /**
     * @var string
     */
    protected static $mediaClass;


    /**
     * @var string
     */
    protected static $userClass;

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

        $config = include Yii::$aliases['@config'].DIRECTORY_SEPARATOR.'media.php';
        self::$mediaClass = $config['mediaClass'];
        self::$mediaClass = $config['userClass'];


        UploadFile::config($config['formats']);

        $return = UploadFile::store($inputName, $type);


        $data = [];

        if($ownerLoggedInUser){

            foreach ($return as $item) {
                $item['size'] = (float) $item['size'];
                $data[] = array_merge($item, [
                    'entity'=>get_class($model),
                    'entity_id'=>$model->id,
                    'owner'=> self::$userClass,
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
                    'entity_id'=>$model->id,
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


}
