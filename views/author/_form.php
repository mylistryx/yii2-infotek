<?php

use app\forms\ImageForm;
use app\models\Author;
use yii\bootstrap5\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/**
 * @var View $this
 * @var Author $model
 * @var ImageForm $imageModel
 */

?>

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

<?= $form->field($model, 'name')->textInput() ?>
<?= $form->field($model, 'surname')->textarea() ?>
<?= $form->field($model, 'patronymic') ?>

<?= $form->field($imageModel, 'imageFile')->fileInput() ?>

<?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update') ?>

<?php ActiveForm::end() ?>