<?php

namespace backend\modules\api\models\category;


use common\models\Category;


class CategoryApi extends Category
{

    public function fields()
    {
        return [
            'id',
            'name',
            'underCategories' => function($data){
                return $data->underCategories;
            }
        ];
    }


    public function get(){
        return self::find()->where(['parentID'=>null])->all();
    }
}