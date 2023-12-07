<?php

namespace app\controllers;

use app\components\controllers\WebController;
use app\forms\ImageForm;
use app\models\AuthorSubscribe;
use app\models\Book;
use yii\base\Exception;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\web\UploadedFile;

final class BookController extends WebController
{
    public function actionIndex(): Response
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Book::find(),
        ]);
        return $this->render('index', ['dataProvider' => $dataProvider]);
    }

    /**
     * @throws NotFoundHttpException
     */
    public function actionView(int|string $id): Response
    {
        $model = $this->findModel($id);
        return $this->render('view', ['model' => $model]);
    }

    /**
     * @throws Exception
     */
    public function actionCreate(): Response
    {
        $model = new Book();
        $imageModel = new ImageForm(['type' => ImageForm::TYPE_BOOK_COVER]);

        if ($model->load($this->post()) && $model->save()) {
            $imageModel->imageFile = UploadedFile::getInstance($imageModel, 'imageFile');
            $imageModel->upload();
            $model->image = $imageModel->getFileName();

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
     * @param int|string $id
     * @return Response
     * @throws NotFoundHttpException
     * @throws Exception
     */
    public function actionUpdate(int|string $id): Response
    {
        $model = $this->findModel($id);
        $imageModel = new ImageForm(['type' => ImageForm::TYPE_BOOK_COVER]);

        if ($model->load($this->post()) && $model->save()) {

            $imageModel->imageFile = UploadedFile::getInstance($imageModel, 'imageFile');
            $imageModel->upload();
            $model->image = $imageModel->getFileName();


            return $this
                ->success('Book updated')
                ->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'imageModel' => $imageModel,
        ]);
    }

    public function actionSubscribe(int|string $id): Response
    {
        $model = new AuthorSubscribe();
        if ($model->load($this->post()) && $model->save()) {
            return $this->success('Subscribe success')->redirect('index');
        }

        return $this->render('subscribe');
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