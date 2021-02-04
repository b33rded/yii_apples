<?php

namespace common\components;

use common\models\User;
use Yii;
use yii\base\Model;
use yii\console\Application;

class Utility
{
    public static function getDateNow(\DateTimeZone $timezone=null, $format='Y-m-d H:i:s'): string
    {
        if (is_null($timezone)) {
            $timezone = new \DateTimeZone(Yii::$app->timeZone);
        }

        $date = new \DateTime('now', $timezone);

        return $date->format($format);
    }

    public static function getModelErrorsString(Model $model): string
    {
        $errorList = $model->getFirstErrors();

        if (empty($errorList)){
            return "";
        }

        if (is_array($errorList)){
            return implode(PHP_EOL, $errorList);
        }

        return "";
    }

}