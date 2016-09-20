<?php

namespace mhndev\yii2Media\Traits;
use mhndev\yii2Media\Media;
use yii\db\ActiveRecord;

/**
 * Class EntityTrait
 * @package mhndev\yii2Media\Traits
 */
trait EntityTrait
{


    protected static $mediaClass;

    protected static $primaryKey;

    /**
     * @param $mediaMimeType
     * @param $mediaType
     * @return mixed
     */
    public function getMediaByType($mediaMimeType, $mediaType)
    {
        return self::$mediaClass->find->where([
            'mime_type' => $mediaMimeType,
            'entity'    => static::class,
            'entity_id' => $this->{self::$primaryKey},
            'type'      => $mediaType
        ])->all();
    }


    /**
     * @return mixed
     */
    public function getMedia()
    {
        return self::$mediaClass->find->where([
            'entity'    => static::class,
            'entity_id' => $this->{self::$primaryKey},
        ])->all();
    }


    /**
     * @param $mediaMimeType
     * @param $mediaType
     * @param $mediaPath
     * @return mixed
     */
    public function attachMedia($mediaMimeType, $mediaType, $mediaPath)
    {
        /** @var ActiveRecord $mediaObject */
        $mediaObject = new self::$mediaClass();

        $mediaObject->type = $mediaType;
        $mediaObject->mimeType = $mediaMimeType;
        $mediaObject->path = $mediaPath;

        $mediaObject->save();

        return $mediaObject;
    }

    /**
     * @param $mediaMimeType
     * @param $mediaType
     * @param $mediaPath
     * @return mixed
     */
    public function detachMedia($mediaMimeType, $mediaType, $mediaPath)
    {
        /** @var ActiveRecord $mediaObject */
        $mediaObject = self::$mediaClass->where([
            'mime_type' => $mediaMimeType,
            'type'      => $mediaType,
            'path'      => $mediaPath
        ])->one();

        $mediaObject->delete();

        return $mediaObject;
    }

    /**
     * @param $mediaId
     * @return mixed
     */
    public function detachMediaById($mediaId)
    {
        $mediaObject = self::$mediaClass->find()->one(['id'=>$mediaId]);

        $mediaObject->delete();

        return $mediaObject;
    }


    /**
     * @return mixed
     */
    public function detachAllMedia()
    {
        return self::$mediaClass->find->where([
            'entity'    => static::class,
            'entity_id' => $this->{self::$primaryKey},
        ])->delete();
    }



    /**
     * @param $mediaMimeType
     * @param $mediaType
     * @return mixed
     */
    public function detachAllMediaByType($mediaMimeType, $mediaType)
    {
        return self::$mediaClass->find->where([
            'mime_type' => $mediaMimeType,
            'entity'    => static::class,
            'entity_id' => $this->{self::$primaryKey},
            'type'      => $mediaType
        ])->delete();
    }


    /**
     * @param $mediaMimeType
     * @param $mediaType
     * @param $max
     * @return mixed
     */
    public function setMaxMediaCanHave($mediaMimeType, $mediaType, $max)
    {

    }

    /**
     * @param $mediaMimeType
     * @param $mediaType
     * @param $fileSize
     * @return mixed
     */
    public function setMaxMediaFileSizeCanHave($mediaMimeType, $mediaType, $fileSize)
    {

    }

}
