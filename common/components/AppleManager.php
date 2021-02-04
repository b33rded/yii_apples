<?php

namespace common\components;

use common\exceptions\ModelNotValidate;
use common\models\Apple;
use common\models\AppleStatus;
use yii\db\Exception;

final class AppleManager
{
    public static function bite(Apple $apple, int $amountBiten): void
    {
        $apple->integrity -= $amountBiten;

        if (!$apple->save()) {
            throw new ModelNotValidate($apple);
        }
    }

    public static function ripOff(Apple $apple): void
    {
        $apple->status_id = AppleStatus::getIdByCode(AppleStatus::ON_GROUND);
        $apple->date_drop = Utility::getDateNow();

        if (!$apple->save()) {
            throw new ModelNotValidate($apple);
        }
    }

    public static function generateApples(int $amount): void
    {
        for ($i = 1; $i <= $amount; $i++) {
            $apple = new Apple([
                'status_id' => AppleStatus::getIdByCode(AppleStatus::ON_TREE),
                'integrity' => 100
            ]);

            if (!$apple->save()) {
                throw new ModelNotValidate($apple);
            }
        }
    }

}