<?php

namespace app\controllers;

use app\components\controllers\WebController;
use app\forms\ImageForm;
use app\models\Author;
use app\models\AuthorSubscribe;
use app\search\AuthorSearch;
use app\search\AuthorSummarySearch;
use Throwable;
use yii\db\StaleObjectException;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\web\UploadedFile;

final class AuthorController extends WebController
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
        $searchModel = new AuthorSearch();
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
        $model = new Author();
        $imageModel = new ImageForm(['type' => ImageForm::TYPE_AUTHOR_PHOTO]);

        if ($model->load($this->post()) && $model->validate()) {
            $imageModel->imageFile = UploadedFile::getInstance($imageModel, 'imageFile');
            $model->save(false);

            if ($imageModel->upload()) {
                $model->image = $imageModel->getFileName();
            }
            $model->save(false);

            return $this
                ->success('Author created')
                ->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'imageModel' => $imageModel,
        ]);
    }

    public function actionUpdate(int|string $id): Response
    {
        $model = $this->findModel($id);
        $imageModel = new ImageForm(['type' => ImageForm::TYPE_AUTHOR_PHOTO]);

        if ($model->load($this->post()) && $model->validate()) {
            $imageModel->imageFile = UploadedFile::getInstance($imageModel, 'imageFile');
            $model->save(false);

            if ($imageModel->upload()) {
                $model->image = $imageModel->getFileName();
            }
            $model->save(false);

            return $this
                ->success('Author created')
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
        return $this->warning('Author deleted')->redirect(['index']);
    }

    /**
     * @throws NotFoundHttpException
     */
    private function findModel(int|string $id): Author
    {
        if ($model = Author::findOne(['id' => $id])) {
            return $model;
        }

        throw new NotFoundHttpException();
    }

    public function actionSubscribe(int|string $id): Response
    {
        $model = new AuthorSubscribe(['author_id' => $this->get()['id'] ?? null]);
        if ($model->load($this->post()) && $model->save()) {
            return $this->success('Subscribe success')->redirect('index');
        }

        return $this->render('subscribe', ['model' => $model]);
    }

    public function actionSummary(): Response
    {
        $searchModel = new AuthorSummarySearch();
        $dataProvider = $searchModel->search($this->queryParams());

        return $this->render('summary', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}