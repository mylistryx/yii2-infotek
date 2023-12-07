<?php

namespace app\controllers;

use app\components\controllers\WebController;
use yii\web\Response;

final class AuthorController extends WebController
{
    public function actionIndex(): Response
    {
        return $this->render('index');
    }

    public function actionView(int|string $id): Response
    {

    }

    public function actionCreate(): Response
    {

    }

    public function actionUpdate(int|string $id): Response
    {

    }

    public function actionSubscribe(int|string $id, string $phone)
    {

    }
}