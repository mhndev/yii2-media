<?php
namespace mhndev\yii2Media\Traits;

use yii\db\ActiveRecord;

/**
 * @property string entity
 * @property string|integer entity_id
 * @property string path
 *
 *
 * Class MediaTrait
 * @package mhndev\yii2Media\Traits
 */
trait MediaTrait
{
    public static $PRIMARY_KEY = 'id';


    /**
     * @return mixed
     */
    public function getEntityClass()
    {
        return $this->entity;
    }

    /**
     * @return array|bool
     */
    public function getEntityObject()
    {
        /** @var ActiveRecord $entityClass */
        $entityClass = $this->getEntityClass();

        return $entityClass->find()->one([self::$PRIMARY_KEY => $this->entity_id]);
    }


    /**
     * @param $entity
     * @param bool $save
     * @return $this
     */
    public function setEntityObject($entity, $save = true)
    {
        $this->entity = get_class($entity);
        $this->entity_id = $entity->id;

        !$save ? : $this->save();

        return $this;
    }

    /**
     * @param $type
     * @param $id
     * @param bool $save
     * @return $this
     */
    public function setEntityByTypeAndIdentifier($type, $id, $save = true)
    {
        $this->entity = get_class($type);
        $this->entity_id = $id;

        !$save ? : $this->save();

        return $this;
    }
}
