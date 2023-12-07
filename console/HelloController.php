<?php

namespace app\console;

use yii\console\Controller;
use yii\console\ExitCode;

class HelloController extends Controller
{
    public function actionIndex(string $message = 'hello world'): int
    {
        $this->stdout($message . "\n");

        return ExitCode::OK;
    }
}
