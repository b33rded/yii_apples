<?php

namespace backend\models\forms;

use common\components\AppleManager;
use common\models\Apple;
use yii\base\Model;


class AppleRipAndBiteForm extends Model
{

    public $bitePercent;

    private Apple $apple;

    public function __construct(Apple $apple, $config = [])
    {
        parent::__construct($config);

        $this->apple = $apple;
    }

    public function rules()
    {
        return [
            [['bitePercent'], 'required'],
            [['bitePercent'], 'integer'],
            [['bitePercent'], 'validateBite'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'bitePercent' => 'Сколько откушено',
        ];
    }

    public function validateBite($attribute, $params): void
    {
        if ($this->apple->integrity - $this->bitePercent < 0) {
            $this->addError(
                'bitePercent',
                'Нельзя съесть больше, чем осталось ;)'
            );
        }
    }

    public function save(): bool
    {
        if(!$this->validate()) {
            return false;
        }

        $transaction = \Yii::$app->db->beginTransaction();

        try {
            AppleManager::ripOff($this->apple);

            AppleManager::bite($this->apple, $this->bitePercent);

            $transaction->commit();

        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }

        return true;
    }

}