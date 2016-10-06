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
 * @property string status
 * @package mhndev\yii2Media
 */

use mhndev\yii2Media\Components\Media as MediaComponent;

class Media extends ActiveRecord implements iMedia
{
    const STATUS_DRAFTED    =   "DRAFTED";
    const STATUS_ACCEPTED   =   "ACCEPTED";
    const STATUS_REJECTED   =   "REJECTED";
    const STATUS_DELETED    =   "DELETED";

    use MediaTrait;

    /**
     * @return string
     */
    public static function tableName()
    {
        $config =   MediaComponent::config();
        return isset($config['table']) ? $config['table'] : 'media';
    }

    
}
