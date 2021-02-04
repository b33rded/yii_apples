<?php

namespace backend\models\forms;

use common\components\AppleManager;
use common\exceptions\ModelNotValidate;
use common\models\Apple;
use yii\base\Model;


class AppleGenerateForm extends Model
{

    public $amount;

    public function __construct($config = [])
    {
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['amount'], 'required'],
            [['amount'], 'integer'],
            [['amount'], 'validateAmount'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'amount' => 'Количество яблок',
        ];
    }

    public function validateAmount($attribute, $params): void
    {
        $this->amount >= 0?: $this->addError('amount', 'Введите число больше ноля');
    }

    public function save(): bool
    {
        if(!$this->validate()) {
            return false;
        }

        $transaction = \Yii::$app->db->beginTransaction();

        try {

            AppleManager::generateApples($this->amount);

            $transaction->commit();

        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }

        return true;
    }

}