<?php
namespace common\components;

use Yii;
use yii\base\BootstrapInterface;

class CheckerBootstrap implements BootstrapInterface
{
    public function bootstrap($app)
    {
        exec("pgrep -f apple-check/run-daemon", $output);

        if (count($output) < 2) {
            exec('/usr/bin/php ' . dirname(dirname(__DIR__)) . '/yii apple-check/run-daemon > /dev/null &');
        }
    }
}