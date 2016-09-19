<?php

namespace mhndev\yii2Media\Interfaces;
/**
 * Interface iEntity
 * @package mhndev\yii2Media\Interfaces
 */
interface iEntity
{

    /**
     * @param $mediaMimeType
     * @param $mediaType
     * @return mixed
     */
    public function getMediaByType($mediaMimeType, $mediaType);


    /**
     * @return mixed
     */
    public function getMedia();

    /**
     * @param $mediaMimeType
     * @param $mediaType
     * @param $mediaPath
     * @return mixed
     */
    public function attachMedia($mediaMimeType, $mediaType, $mediaPath);

    /**
     * @param $mediaMimeType
     * @param $mediaType
     * @param $mediaPath
     * @return mixed
     */
    public function detachMedia($mediaMimeType, $mediaType, $mediaPath);

    /**
     * @param $mediaId
     * @return mixed
     */
    public function detachMediaById($mediaId);

    /**
     * @param $mediaMimeType
     * @param $mediaType
     * @param $max
     * @return mixed
     */
    public function setMaxMediaCanHave($mediaMimeType, $mediaType, $max);

    /**
     * @param $mediaMimeType
     * @param $mediaType
     * @param $fileSize
     * @return mixed
     */
    public function setMaxMediaFileSizeCanHave($mediaMimeType, $mediaType, $fileSize);

    /**
     * @return mixed
     */
    public function detachAllMedia();


    /**
     * @param $mediaMimeType
     * @param $mediaType
     * @return mixed
     */
    public function detachAllMediaByType($mediaMimeType, $mediaType);

}
