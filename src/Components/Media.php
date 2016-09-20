<?php

namespace mhndev\yii2Media\Components;

use app\modules\user\models\User;
use mhndev\media\UploadFile;
use mhndev\yii2Media\Interfaces\iEntity;
use Yii;

/**
 * Class Media
 * @package mhndev\yii2Media\Components
 */
class Media
{


    protected static $mediaClass;

    /**
     * @param $inputName
     * @param $type
     * @param $model
     * @param bool $ownerLoggedInUser
     * @return array|string
     */
    public static function storeAndAttach($inputName, $type, $model, $ownerLoggedInUser = true)
    {

        $config = include Yii::$aliases['@config'].DIRECTORY_SEPARATOR.'media.php';
        self::$mediaClass = $config['mediaClass'];


        UploadFile::config($config['formats']);

        $return = UploadFile::store($inputName, $type);


        $data = [];
        foreach ($return as $item) {
            $item['size'] = (float) $item['size'];
            $data[] = array_merge($item, [ 'entity'=>get_class($model),'entity_id'=>$model->id,'owner'=> User::class, 'owner_id'=>12, 'link'=>null, 'type'=>$type]);
        }




        /** @var iEntity $model */
        $model->attachMultipleMedia($data, false);
    }


}
