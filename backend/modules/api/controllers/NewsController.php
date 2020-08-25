<?php

namespace backend\modules\api\controllers;


use backend\modules\api\controllers\base\BaseController;
use backend\modules\api\models\news\NewsApi;
use yii\filters\AccessControl;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;


class NewsController extends BaseController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['authenticator']['authMethods'] = [
            HttpBasicAuth::class,
            HttpBearerAuth::class,
        ];

        $behaviors['access'] = [
            'class' => AccessControl::className(),
            'rules' => [
                [
                    'actions' => ['index'],
                    'allow' => true,
                    'roles' => ['@'],
                ],
            ]
        ];

        return $behaviors;
    }

    public $modelClass = NewsApi::class;

    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    protected function verbs()
    {
        return [
            'index' => ['GET'],
        ];
    }

    public function actionIndex($category)
    {
        $model = new NewsApi();
        $model->categoryID = $category;
        return [
            'news' => $model->get(),
            'newsByChildCategories' => $model->getNewsByChildCategories(),
        ];
    }

}