<?php
namespace mhndev\yii2Media\Traits;

use yii\db\ActiveRecord;

/**
 * @property string entity
 * @property string|integer entity_id
 * @property string path
 * @property string created_at
 * @property string updated_at

 * Class MediaTrait
 * @package mhndev\yii2Media\Traits
 */
trait MediaTrait
{

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

        return $entityClass->find()->one([ static::primaryKey() => $this->entity_id]);
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

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        if(!empty($this->parent_id)) {

            $parent = $this->getParent();

            if (!empty($parent->path)){
                $this->path = $parent->path . '' . $parent->id;
            }
            else{
                $this->path = $parent->id;
            }
        }

        if (parent::beforeSave($insert)) {
            if($insert)
                $this->created_at = date('Y-m-d H:i:s');
            $this->updated_at = date('Y-m-d H:i:s');
            return true;
        } else {
            return false;
        }


    }

    /**
     * @return $this
     */
    public function markAsDefault()
    {
        static::updateAll(['default' => 0], [
            'and',
            ['=','entity', $this->entity],
            ['=', 'entity_id', $this->entity_id],
        ]);

        $this->default = 1;
        $this->save();

        return $this;
    }

    /**
     * @return $this
     */
    public function unMarkAsDefault()
    {
        $this->default = 0;
        $this->save();

        return $this;
    }

}
