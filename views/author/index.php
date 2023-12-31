<?php
/**
 * @var DataProviderInterface $dataProvider
 * @var BookSearch $searchModel
 */

use app\models\Author;
use app\search\BookSearch;
use yii\bootstrap5\Html;
use yii\data\DataProviderInterface;
use yii\grid\ActionColumn;
use yii\grid\GridView;

$this->title = 'Authors';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="author-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (!Yii::$app->user->isGuest): ?>
        <p>
            <?= Html::a('Add author', ['create'], ['class' => 'btn btn-success']) ?>
            <?= Html::a('Summary', ['summary'], ['class' => 'btn btn-success']) ?>
        </p>
    <?php endif; ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            'name',
            'surname',
            'patronymic',
            [
                'attribute' => 'books',
                'format' => 'raw',
                'value' => function ($model) {
                    $response = [];
                    /** @var Author $model */
                    foreach ($model->books as $book) {
                        $response[] = '<p>' . Html::a(trim($book->title), ['/book/view', 'id' => $book->id]) . '</p>';
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
