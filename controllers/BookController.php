<?php

namespace app\controllers;

use app\components\controllers\WebController;
use app\forms\ImageForm;
use app\models\AuthorSubscribe;
use app\models\Book;
use app\search\BookSearch;
use Throwable;
use yii\base\Exception;
use yii\data\ActiveDataProvider;
use yii\db\StaleObjectException;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\web\UploadedFile;

final class BookController extends WebController
{
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['create', 'update', 'delete'],
                'rules' => [
                    [
                        'actions' => ['create', 'update', 'delete'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex(): Response
    {
        $searchModel = new BookSearch();
        $dataProvider = $searchModel->search($this->queryParams());

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @throws NotFoundHttpException
     */
    public function actionView(int|string $id): Response
    {
        $model = $this->findModel($id);
        return $this->render('view', ['model' => $model]);
    }

    public function actionCreate(): Response
    {
        $model = new Book();
        $imageModel = new ImageForm(['type' => ImageForm::TYPE_BOOK_COVER]);
        if ($model->load($this->post()) && $model->validate()) {
            $imageModel->imageFile = UploadedFile::getInstance($imageModel, 'imageFile');

            if ($imageModel->upload()) {
                $model->image = $imageModel->getFileName();
            }
            $model->save(false);

            return $this
                ->success('Book created')
                ->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'imageModel' => $imageModel,
        ]);
    }

    /**
     * @throws NotFoundHttpException
     */
    public function actionUpdate(int|string $id): Response
    {
        $model = $this->findModel($id);
        $imageModel = new ImageForm(['type' => ImageForm::TYPE_BOOK_COVER]);
        if ($model->load($this->post()) && $model->validate()) {
            $imageModel->imageFile = UploadedFile::getInstance($imageModel, 'imageFile');

            if ($imageModel->upload()) {
                $model->image = $imageModel->getFileName();
            }
            $model->save(false);

            return $this
                ->success('Book created')
                ->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'imageModel' => $imageModel,
        ]);
    }

    /**
     * @throws NotFoundHttpException
     * @throws Throwable
     * @throws StaleObjectException
     */
    public function actionDelete(int|string $id): Response
    {
        $model = $this->findModel($id);
        $model->delete();
        return $this->warning('Book deleted')->redirect(['index']);
    }

    /**
     * @throws NotFoundHttpException
     */
    protected function findModel(int|string $id): Book
    {
        if ($model = Book::findOne(['id' => $id])) {
            return $model;
        }

        throw new NotFoundHttpException();
    }
}