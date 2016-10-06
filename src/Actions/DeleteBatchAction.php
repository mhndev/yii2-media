<?php
/**
 * Created by IntelliJ IDEA.
 * User: moein
 * Date: 10/2/16
 * Time: 4:43 PM
 */

namespace mhndev\Actions;

use yii\rest\Action;
use mhndev\yii2Media\Components\Media;

class DeleteBatchAction extends Action {

    public $modelClass  =   Media::class;

    public function run()
    {
        $data       =   Yii::$app->request->post();
        
        return Media::deleteBatch($data['entity'], $data['entities_id']);
    }
}