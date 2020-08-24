<?php

namespace backend\controllers;

use common\models\Category;
use common\models\NewsCategories;
use Yii;
use common\models\News;
use common\forms\search\NewsSearch;
use yii\helpers\ArrayHelper;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * NewsController implements the CRUD actions for News model.
 */
class NewsController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all News models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new NewsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single News model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new News model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new News();
        $newsCategoriesModel = new NewsCategories();
        $categories = Category::getCategoriesMap();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            NewsCategories::create(Yii::$app->request->post('NewsCategories')['categoryID'],$model->id);
            return $this->redirect(['view', 'id' => $model->id]);
        }
        if(!$categories){
            Yii::$app->session->setFlash('error', 'Нет категорий. Пожалуйста создайте хотя бы одну категорию, что бы создать новость.');
            return $this->redirect(Yii::$app->request->referrer);
        }

        return $this->render('create', compact('model','categories','newsCategoriesModel'));
    }

    /**
     * Updates an existing News model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $newsCategoriesModel = new NewsCategories();
        $categories = Category::getCategoriesMap();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            NewsCategories::create(Yii::$app->request->post('NewsCategories')['categoryID'],$model->id);
            return $this->redirect(['view', 'id' => $model->id]);
        }
        if(!$categories){
            Yii::$app->session->setFlash('error', 'Нет категорий. Пожалуйста создайте хотя бы одну категорию, что бы создать новость.');
            return $this->redirect(Yii::$app->request->referrer);
        }

        return $this->render('update', compact('model','categories','newsCategoriesModel'));

    }

    /**
     * Deletes an existing News model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the News model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return News the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = News::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
