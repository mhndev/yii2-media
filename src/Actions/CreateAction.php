<?php
/**
 * Created by IntelliJ IDEA.
 * User: moein
 * Date: 10/2/16
 * Time: 4:20 PM
 */

namespace mhndev\yii2Media\Actions;

use Yii;
use yii\rest\Action;
use mhndev\yii2Media\Components\Media;

class CreateAction extends Action {

    public function run()
    {
        $data       =   Yii::$app->request->post();
        
        $entity     =   $this->modelClass;
        $model      =   $entity::findOne($data['entity_id']);

        return ['records'=> Media::storeAndAttach('media', $data['type'], $model)];
    }
}