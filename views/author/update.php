<?php

use app\forms\ImageForm;
use app\models\Author;
use yii\web\View;

/**
 * @var View $this
 * @var Author $model
 * @var ImageForm $imageModel
 */
echo $this->render('_form', [
    'model' => $model,
    'imageModel' => $imageModel,
]);