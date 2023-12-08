<?php
/**
 * @var View $this
 * @var Book $model
 */

use app\forms\ImageForm;
use app\models\Book;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\DetailView;

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Books', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="book-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (!Yii::$app->user->isGuest): ?>
        <p>
            <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-info']) ?>
            <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]) ?>
        </p>
    <?php endif; ?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'description:ntext',
            'year',
            'isbn',
            [
                'attribute' => 'image',
                'format' => 'raw',
                /** @var Book $model */
                'value' => fn($model) => Html::img('/storage' . DIRECTORY_SEPARATOR . ImageForm::TYPE_FOLDERS[$model::TYPE] . DIRECTORY_SEPARATOR . $model->image),
            ],
            [
                'attribute' => 'authors',
                'format' => 'raw',
                'value' => function ($model) {
                    $response = [];
                    /** @var Book $model */
                    foreach ($model->authors as $author) {
                        $response[] = '<p>' . Html::a(trim(implode(' ', [$author->surname, $author->name, $author->patronymic])), ['/author/view', 'id' => $author->id]) . '</p>';
                    }
                    return implode("\n", $response);
                },
            ],
        ],
    ]) ?>

</div>