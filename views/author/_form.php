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
    <div class="row">
        <div class="col-4">
            <?= $form->field($model, 'name')->textInput(['autofocus' => true]) ?>
        </div>
        <div class="col-4">
            <?= $form->field($model, 'surname')->textInput() ?>
        </div>
        <div class="col-4">
            <?= $form->field($model, 'patronymic')->textInput() ?>
        </div>

        <?= $form->field($imageModel, 'imageFile')->fileInput(['accept' => 'image/*']) ?>

        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => ['btn', 'btn-success']]) ?>
    </div>

<?php ActiveForm::end() ?>