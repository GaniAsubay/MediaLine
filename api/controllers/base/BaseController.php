<?php


namespace api\controllers\base;

use yii\rest\Controller;
use yii\web\NotFoundHttpException;

class BaseController extends Controller
{
    protected function findModel($id)
    {
        if (($model = $this->modelClass::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}