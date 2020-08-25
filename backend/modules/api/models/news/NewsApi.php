<?php

namespace backend\modules\api\models\news;


use common\models\News;


class NewsApi extends News
{
    public $categoryID;

    public function fields()
    {
        return [
            'id',
            'title',
            'description',
            'creator' => function ($data){
                return $data->author->username;
            },
            'createdAt',
        ];
    }

    public function getNewsByChildCategories(){
        return self::find()->select('news.*')->joinWith('newsCategories.category')
            ->where(['news.isDeleted'=>false])
            ->andWhere(['category.parentID'=>$this->categoryID])->all();
    }

    public function get(){
        return self::find()->select('news.*')->joinWith('newsCategories')->where(['news.isDeleted'=>false])
            ->andWhere(['news_categories.categoryID'=>$this->categoryID])->all();

    }

}