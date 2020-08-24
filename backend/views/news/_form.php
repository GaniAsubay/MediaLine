<?php

use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\News */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="news-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($newsCategoriesModel, 'categoryID')->widget(Select2::classname(), [
        'data' => $categories,
        'language' => 'ru',
        'options' => ['multiple' => true,'placeholder' => 'Выберите категорию','value'=>$model->newsCategoriesId ?? []],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);?>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
