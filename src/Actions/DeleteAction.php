<?php
/**
 * Created by IntelliJ IDEA.
 * User: moein
 * Date: 10/2/16
 * Time: 4:21 PM
 */

namespace mhndev\Actions;

use yii\rest\Action;
use mhndev\yii2Media\Models\Media;

class DeleteAction extends Action {
    
    public $modelClass  =   Media::class;
    
    public function run()
    {
        $data       =   Yii::$app->request->post();

        $entity     =   $this->modelClass;
        $model      =   $entity::findOne($data['entity_id']);

        return $model->softDelete();
    }
}