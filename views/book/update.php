<?php
/**
 * @var View $this
 * @var Book $model
 * @var ImageForm $imageModel
 */

use app\forms\ImageForm;
use app\models\Book;
use yii\web\View;

$this->title = 'Update book ' . $model->title;
$this->params['breadcrumbs'][] = ['url' => ['index'], 'label' => 'Books'];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="book-update">
    <?= $this->render('_form', [
        'model' => $model,
        'imageModel' => $imageModel,
    ]) ?>
</div>
