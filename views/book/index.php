<?php
/**
 * @var DataProviderInterface $dataProvider
 * @var BookSearch $searchModel
 */

use app\models\Book;
use app\search\BookSearch;
use yii\bootstrap5\Html;
use yii\data\DataProviderInterface;
use yii\grid\ActionColumn;
use yii\grid\GridView;

$this->title = 'Books';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="book-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php if (!Yii::$app->user->isGuest): ?>
        <p>
            <?= Html::a('Create Book', ['create'], ['class' => 'btn btn-success']) ?>
        </p>
    <?php endif; ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            'title',
            'description:ntext',
            'year',
            'isbn',
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
            [
                'class' => ActionColumn::class,
                'template' => Yii::$app->user->isGuest ? '{view}' : '{view} {update} {delete}',
            ],
        ],
    ]); ?>


</div>
