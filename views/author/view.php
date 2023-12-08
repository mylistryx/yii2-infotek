<?php
/**
 * @var View $this
 * @var Author $model
 */

use app\forms\ImageForm;
use app\models\Author;
use app\models\Book;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\DetailView;

$this->title = trim(implode(' ', [$model->surname, $model->name, $model->patronymic]));
$this->params['breadcrumbs'][] = ['label' => 'Authors', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="author-view">

    <h1><?= Html::encode(trim(implode(' ', [$model->surname, $model->name, $model->patronymic]))) ?></h1>
    <p>
        <?= Html::a('Subscribe', ['subscribe', 'id' => $model->id], ['class' => ['btn', 'btn-warning']]) ?>
        <?php if (!Yii::$app->user->isGuest): ?>
            <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-info']) ?>
            <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]) ?>
        <?php endif; ?>
    </p>

    <?php
    $attributes = [
        [
            'label' => 'Name',
            'value' => fn($model) => trim(implode(' ', [$model->surname, $model->name, $model->patronymic])),
        ],
        [
            'attribute' => 'image',
            'format' => 'raw',
            /** @var Book $model */
            'value' => fn($model) => Html::img('/storage' . DIRECTORY_SEPARATOR . ImageForm::TYPE_FOLDERS[$model::TYPE] . DIRECTORY_SEPARATOR . $model->image),
        ],
        [
            'attribute' => 'books',
            'format' => 'raw',
            'value' => function ($model) {
                $response = [];
                /** @var Author $model */
                foreach ($model->books as $book) {
                    $response[] = '<p>' . Html::a(trim($book->title), ['/author/view', 'id' => $book->id]) . '</p>';
                }
                return implode("\n", $response);
            },
        ],
    ];

    if (!Yii::$app->user->isGuest) {
        $attributes[] = [
            'label' => 'Author subscribers',
            'format' => 'raw',
            'value' => function ($model) {
                $response = [];
                foreach ($model->subscribers as $subscriber) {
                    $response[] = "<p>+7 (" . substr($subscriber->phone, 0, 3) . ") " . substr($subscriber->phone, 3, 3) . '-' . substr($subscriber->phone, 6) . "</p>";
                }

                return implode("\n", $response);
            },
        ];
    }
    ?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => $attributes,
    ]) ?>

</div>