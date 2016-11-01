<?php
/**
 * Created by IntelliJ IDEA.
 * User: moein
 * Date: 10/2/16
 * Time: 4:40 PM
 */

namespace mhndev\yii2Media\Actions;

use yii\rest\Action;
use yii\data\Pagination;
use mhndev\yii2Media\Models\Media;


class ListAction extends Action {

    public $modelClass  =   Media::class;

    public function run()
    {
        $data       =   Yii::$app->request->post();
        $pageSize   =   isset($data['per-size'])?$data['per-size']:7;
        $page       =   isset($data['page'])?$data['page']:0;
        $orderBy    =   isset($data['order-by'])?$data['order-by']:'created_at';
        $entity     =   $this->modelClass;
        $query      =   Media::find()->where(['entity'  =>  $entity]);
        $count      =   $query->count();
        $pagination =   new Pagination(['totalCount' => $count, 'defaultPageSize'=>$pageSize, 'params'=>['page'=>$page]]);

        return  $query->offset($pagination->offset)
                        ->limit($pagination->pageSize)
                        ->orderBy($orderBy)
                        ->all();
    }
}