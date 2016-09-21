<?php
namespace mhndev\yii2Media;

use yii\base\BootstrapInterface;
use yii\base\Module as BaseModule;
use yii\console\Application as ConsoleApplication;

/**
 * Class Module
 * @package mhndev\yii2Media
 */
class Module extends BaseModule implements BootstrapInterface
{

    public $db = 'db';

    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'mhndev\yii2Media\Controllers';


    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
    }

    /**
     * @param \yii\base\Application $app
     */
    public function bootstrap($app)
    {
        if ($app instanceof ConsoleApplication) {
            $this->controllerNamespace = 'mhndev\yii2Media\commands';
        }
    }
}
