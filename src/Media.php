<?php

namespace mhndev\yii2Media;

use mhndev\yii2Media\Interfaces\iMedia;
use mhndev\yii2Media\Traits\MediaTrait;
use yii\db\ActiveRecord;

/**
 * Class Media
 * @package mhndev\yii2Media
 */
class Media extends ActiveRecord implements iMedia
{
    use MediaTrait;

}
