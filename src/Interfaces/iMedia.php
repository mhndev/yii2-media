<?php

namespace mhndev\yii2Media\Interfaces;
/**
 * Interface iMedia
 * @package mhndev\yii2Media\Interfaces
 */
interface iMedia
{
    /**
     * @return mixed
     */
    public function getEntityClass();

    /**
     * @return mixed
     */
    public function getEntityObject();

    /**
     * @param $entity
     * @return mixed
     */
    public function setEntityObject($entity);

    /**
     * @param string $type
     * @param string $id
     * @return mixed
     */
    public function setEntityByTypeAndIdentifier($type, $id);


    public function markAsDefault();

    public function unMarkAsDefault();
}
