<?php
namespace mhndev\yii2Media\Controllers;

use mhndev\yii2Media\Components\Media;
use Yii;
use yii\web\Controller;
use yii\web\Response;

/**
 * Class MediaController
 * @package mhndev\yii2Media\Controllers
 */
class MediaController extends Controller
{

    /**
     * @var bool
     */
    public $enableCsrfValidation = false;


    /**
     * init
     */
    public function init()
    {
        parent::init();

        Yii::$app->response->format = Response::FORMAT_JSON;
    }


    /**
     * @return array
     */
    public function behaviors()
    {
        $configPath = $this->module->getBasePath().DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'behaviors.php';
        $config = include $configPath;

        return $config[self::class];
    }

    /**
     * @return array
     */
    public function verbs()
    {
        return [
            'default-media' => ['POST'],
            'upload-and-attach-media' => ['POST'],
        ];
    }


    /**
     * @param $id
     * @return mixed
     */
    public function actionDefaultMedia($id)
    {
        return Media::markMediaAsDefaultByMediaId($id);
    }


    /**
     * @return array|string
     */
    public function actionUploadAndAttachMedia()
    {
        $data = Yii::$app->request->post();
        $model = $data['entity']::findOne($data['entity_id']);

        return ['records'=>Media::storeAndAttach('media', $data['type'], $model)];
    }


}
