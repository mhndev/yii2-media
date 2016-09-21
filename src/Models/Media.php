<?php

namespace mhndev\yii2Media\Models;

use mhndev\yii2Media\Interfaces\iMedia;
use mhndev\yii2Media\Traits\MediaTrait;
use yii\db\ActiveRecord;

/**
 * Class Media
 * @property  string type
 * @property  string mime_type
 * @property  string owner
 * @property  string owner_id
 * @property  int default
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




}
