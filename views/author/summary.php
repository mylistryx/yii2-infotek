<?php
/**
 * @var DataProviderInterface $dataProvider
 * @var AuthorSummarySearch $searchModel
 */

use app\models\Author;
use app\models\Book;
use app\search\AuthorSummarySearch;
use yii\bootstrap5\Html;
use yii\data\DataProviderInterface;
use yii\grid\GridView;

$this->title = 'Authors summary';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="author-summary">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            'name',
            'surname',
            'patronymic',
            [
                'attribute' => 'year',
                'value' => fn($model) => $model->yearCounter,
            ],
            [
                'attribute' => 'books',
                'format' => 'raw',
                'value' => function ($model) use ($searchModel) {
                    $response = [];
                    /** @var Author $model */
                    foreach ($model->getBooks()->andWhere(['year' => $searchModel->year])->all() as $book) {
                        /** @var Book $book */
                        $response[] = '<p>' . Html::a(trim($book->title), ['/book/view', 'id' => $book->id]) . '</p>';
                    }
                    return implode("\n", $response);
                },
            ],
        ],
    ]); ?>


</div>
