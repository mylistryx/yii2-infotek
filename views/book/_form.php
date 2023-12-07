<?php

use app\forms\ImageForm;
use app\models\Book;
use yii\bootstrap5\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/**
 * @var View $this
 * @var Book $model
 * @var ImageForm $imageModel
 */

?>

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

<?= $form->field($model, 'title')->textInput() ?>
<?= $form->field($model, 'description')->textarea() ?>
<?= $form->field($model, 'year') ?>
<?= $form->field($model, 'isbn') ?>

<?= $form->field($imageModel, 'imageFile')->fileInput() ?>

<?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update') ?>

<?php ActiveForm::end() ?>