<?php
/**
 * @var View $this
 * @var Author $model
 * @var ImageForm $imageModel
 */

use app\forms\ImageForm;
use app\models\Author;
use yii\web\View;

$this->title = 'Add author';
$this->params['breadcrumbs'][] = ['url' => ['index'], 'label' => 'Authors'];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="author-create">
    <?= $this->render('_form', [
        'model' => $model,
        'imageModel' => $imageModel,
    ]) ?>
</div>
