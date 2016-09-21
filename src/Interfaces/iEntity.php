<?php

namespace mhndev\yii2Media\Interfaces;
use yii\db\ActiveRecord;

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
     * attach media to an entity which takes owner class and owner identifier as arguments
     *
     * @param $mediaMimeType
     * @param $mediaType
     * @param $mediaPath
     * @param $owner
     * @param $owner_id
     * @return mixed
     */
    public function attachMedia($mediaMimeType, $mediaType, $mediaPath, $owner, $owner_id);


    /**
     * @param array $media
     * @param bool $ownerEqualsLoggedInUser
     */
    public function attachMultipleMedia(array $media, $ownerEqualsLoggedInUser = true);



    /**
     *
     * attach media to an entity which logged in user is it's owner
     *
     * @param $mediaMimeType
     * @param $mediaType
     * @param $mediaPath
     * @return ActiveRecord
     */
    public function attachMediaLoggedInUser($mediaMimeType, $mediaType, $mediaPath);



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
