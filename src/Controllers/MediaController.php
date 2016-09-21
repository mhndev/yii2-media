<?php
namespace mhndev\yii2Media\Controllers;

use mhndev\yii2Media\Components\Media;
use yii\web\Controller;

/**
 * Class MediaController
 * @package mhndev\yii2Media\Controllers
 */
class MediaController extends Controller
{

    /**
     * @param $id
     */
    public function actionDefaultMedia($id)
    {
        Media::markMediaAsDefault($id);
    }


}
