<?php

namespace mhndev\yii2Media\Traits;

use mhndev\yii2Media\Models\Media;
use Yii;
use yii\db\ActiveRecord;

/**
 * Class EntityTrait
 * @package mhndev\yii2Media\Traits
 */
trait EntityTrait
{

    /**
     * @var string
     */
    protected static $mediaClass;

    public function init()
    {
        parent::init();

        $config = include Yii::$aliases['@config'].DIRECTORY_SEPARATOR.'media.php';
        self::$mediaClass = $config['mediaClass'];
    }

    /**
     * @param $mediaMimeType
     * @param $mediaType
     * @return mixed
     */
    public function getMediaByType($mediaMimeType, $mediaType)
    {
        /** @var ActiveRecord $mediaClass */
        $mediaClass = self::$mediaClass;

        return $mediaClass->find()->where([
            ['=', 'mime_type' , $mediaMimeType],
            ['=', 'entity'    , static::class],
            ['=', 'entity_id' , $this->{$mediaClass::primaryKey()}],
            ['=', 'type'      , $mediaType]
        ])->all();
    }


    /**
     * @return mixed
     */
    public function getMedia()
    {
        /** @var ActiveRecord $mediaClass */
        $mediaClass = self::$mediaClass;

        return $mediaClass->find()->where([
            ['=', 'entity', static::class],
            ['=', 'entity_id', $this->{$mediaClass::primaryKey()}],
        ])->all();
    }


    /**
     * attach media to an entity which takes owner class and owner identifier as arguments
     *
     * @param $mediaMimeType
     * @param $mediaType
     * @param $mediaPath
     * @param $owner
     * @param $owner_id
     * @return mixed
     */
    public function attachMedia($mediaMimeType, $mediaType, $mediaPath, $owner, $owner_id)
    {
        /** @var Media $mediaObject */
        $mediaObject = new self::$mediaClass();

        $mediaObject->type = $mediaType;
        $mediaObject->mime_type = $mediaMimeType;
        $mediaObject->path = $mediaPath;
        $mediaObject->owner = $owner;
        $mediaObject->owner_id = $owner_id;
        $mediaObject->entity = static::class;
        $mediaObject->entity_id = $this->id;

        $mediaObject->save();

        return $mediaObject;
    }


    /**
     * @param array $media
     * @param bool $ownerEqualsLoggedInUser
     */
    public function attachMultipleMedia(array $media, $ownerEqualsLoggedInUser = true)
    {
        $result = [];

        if($ownerEqualsLoggedInUser){

            $ownerClass = get_class(Yii::$app->user->identity);
            $owner_id   = Yii::$app->user->identity->id;

            foreach ($media as $record){
                $result[] = array_merge($record, [
                    'entity' => static::class,
                    'entity_id'=> $this->id,
                    'owner' => $ownerClass,
                    'owner_id' => $owner_id
                ]);
            }
        }
        else{
            foreach ($media as $record){
                $result[] = array_merge($record, [
                    'entity' => static::class,
                    'entity_id'=> $this->id
                ]);
            }
        }


        $this->createMany($result);
    }


    /**
     * @param array $data
     * @return mixed|void
     * @throws \Exception
     */
    protected function createMany(array $data)
    {
        if($this->depth($data) < 2){
            throw new \Exception;
        }

        $modelClassName = self::$mediaClass;

        foreach ($data as $record){
            /** @var ActiveRecord $model */
            $model = new $modelClassName;

            foreach($record as $key => $value){
                $model->{$key} = $value;
            }

            if(!$model->validate()){
                break;
            }

        }

        Yii::$app->db->createCommand()
            ->batchInsert($modelClassName::tableName(),
                ['entity','size','entity_id', 'owner', 'owner_id', 'type', 'file_type', 'mime_type', 'path', 'link'],
                $data)->execute();
    }


    /**
     *
     * attach media to an entity which logged in user is it's owner
     *
     * @param $mediaMimeType
     * @param $mediaType
     * @param $mediaPath
     * @return ActiveRecord
     */
    public function attachMediaLoggedInUser($mediaMimeType, $mediaType, $mediaPath)
    {
        /** @var Media $mediaObject */
        $mediaObject = new self::$mediaClass();

        $mediaObject->type = $mediaType;
        $mediaObject->mime_type = $mediaMimeType;
        $mediaObject->path = $mediaPath;
        $mediaObject->owner = get_class(Yii::$app->user->identity);
        $mediaObject->owner_id = Yii::$app->user->identity->id;
        $mediaObject->entity = static::class;
        $mediaObject->entity_id = $this->id;

        $mediaObject->save();

        return $mediaObject;
    }



    /**
     * @return mixed
     */
    public function detachAllMedia()
    {
        /** @var ActiveRecord $mediaClass */
        $mediaClass = self::$mediaClass;

        return $mediaClass::deleteAll([
            'and',
            ['=', 'entity', static::class ],
            ['=', 'entity_id', $this->{$mediaClass::primaryKey()} ]
        ]);


    }



    /**
     * @param $mediaMimeType
     * @param $mediaType
     * @return mixed
     */
    public function detachAllMediaByType($mediaMimeType, $mediaType)
    {
        /** @var ActiveRecord $mediaClass */
        $mediaClass = self::$mediaClass;

        return $mediaClass::deleteAll([
            'and',
            ['=', 'entity', static::class ],
            ['=', 'entity_id', $this->{$mediaClass::primaryKey()} ],
            ['=', 'mime_type', $mediaMimeType],
            ['=', 'type', $mediaType],
        ]);
    }



    /**
     * @param array $array
     * @return int
     */
    protected function depth(array $array)
    {
        $max_depth = 1;

        foreach ($array as $value) {
            if (is_array($value)) {
                $depth = $this->depth($value) + 1;

                if ($depth > $max_depth) {
                    $max_depth = $depth;
                }
            }
        }

        return $max_depth;
    }


}
