<?php

use app\forms\ImageForm;
use app\models\Author;
use app\models\Book;
use yii\bootstrap5\Html;
use yii\web\View;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;

/**
 * @var View $this
 * @var Book $model
 * @var ImageForm $imageModel
 */

?>

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>
    <div class="row">
        <div class="col-12">
            <?= $form->field($model, 'title')->textInput() ?>
        </div>
        <div class="col-12">
            <?= $form->field($model, 'description')->textarea() ?>
        </div>
        <div class="col-1">
            <?= $form->field($model, 'year')->dropDownList($model->yearsRange) ?>
        </div>
        <div class="col-2">
            <?= $form->field($model, 'isbn')->widget(MaskedInput::class, ['mask' => ['9-999-99999-9', '999-9-999-99999-9']]) ?>
        </div>
        <div class="col-3">
            <?= $form->field($imageModel, 'imageFile')->fileInput(['accept' => 'image/*']) ?>
        </div>
        <div class="col-6">
            <?= $form->field($model, 'selectedAuthors')->listBox($model->allAuthors, ['multiple' => true]) ?>
        </div>
        <div class="col-12">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => ['btn', 'btn-info']]) ?>
        </div>
    </div>
<?php ActiveForm::end() ?>