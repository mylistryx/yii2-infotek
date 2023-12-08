<?php
/**
 * @var View $this
 * @var AuthorSubscribe $model
 */

use app\models\AuthorSubscribe;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use yii\web\View;
use yii\widgets\MaskedInput;

$this->title = "Subscribe author [ " . $model->author->fullName . " ]";
$this->params['breadcrumbs'][] = ['url' => ['index'], 'label' => 'Authors'];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="author-create">
    <h1>
        <?= Html::encode($this->title) ?>
    </h1>
    <?php $form = ActiveForm::begin() ?>
    <div class="row">
        <div class="col-4">
            <?= $form->field($model, 'author_id')->hiddenInput()->label(false) ?>
            <?= $form->field($model, 'phone')->textInput(['autofocus' => true])->widget(MaskedInput::class, ['mask' => '+7(999)999-99-99']) ?>
        </div>
        <div class="col-12">
            <?= Html::submitButton('Subscribe', ['class' => ['btn', 'btn-info']]) ?>
        </div>
    </div>

    <?php ActiveForm::end() ?>
</div>
