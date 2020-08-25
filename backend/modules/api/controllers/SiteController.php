<?php
namespace backend\modules\api\controllers;

use backend\modules\api\controllers\base\BaseController;
use common\models\LoginForm;
use Yii;
/**
 * Site controller
 */
class SiteController extends BaseController
{
    protected function verbs()
    {
        return [
            'login' => ['post', 'options']
        ];
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        $model = new LoginForm();
        $params = Yii::$app->request->bodyParams;
        $model->load($params, '');
        if ($token = $model->apiAuth()) {
            return [
                'token' => $token->token,
                'expired' => date(DATE_RFC3339, $token->expired_at),
            ];
        } else {
            return $model;
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

}
