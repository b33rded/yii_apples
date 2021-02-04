<?php
namespace console\controllers;

use common\models\Apple;
use common\models\AppleStatus;
use DateTime;
use yii\console\Controller;

class AppleCheckController extends Controller
{
    public function actionRunDaemon()
    {
        while (true) {
            $apples = Apple::find()
                ->where(['NOT', ['date_drop' => NULL]])
                ->andWhere(['NOT', ['status_id' => AppleStatus::getIdByCode(AppleStatus::ROTTEN)]])
                ->all();

            foreach ($apples as $apple) {
                $drop = new DateTime($apple->date_drop);
                $now = new DateTime();
                $interval = $now->diff($drop);
                if($interval->h >= 5) {
                    $apple->status_id = AppleStatus::getIdByCode(AppleStatus::ROTTEN);
                    $apple->save();
                }
            }

            sleep(900);
        }

    }
}