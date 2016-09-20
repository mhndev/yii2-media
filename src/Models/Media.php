<?php

namespace mhndev\yii2Media\Models;

use mhndev\yii2Media\Interfaces\iMedia;
use mhndev\yii2Media\Traits\MediaTrait;
use yii\db\ActiveRecord;

/**
 * Class Media
 * @property string type
 * @property  string mime_type
 * @property  string owner
 * @property  string owner_id
 * @package mhndev\yii2Media
 */
class Media extends ActiveRecord implements iMedia
{
    use MediaTrait;

    /**
     * @return string
     */
    public static function tableName()
    {
        return 'media';
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
}
