<?php

namespace app\console;

use app\models\Identity;
use yii\console\Controller;
use yii\console\ExitCode;

final class IdentityController extends Controller
{
    public function actionCreate(string $email, string $password): int
    {
        Identity::create($email, $password);

        return ExitCode::OK;
    }
}