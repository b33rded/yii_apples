<?php

namespace common\exceptions;

use common\components\Utility;
use yii\base\Model;

class ModelNotValidate extends \Exception
{
    private $model;

    public function __construct(Model $model = null, $message = null, $code = 0, \Exception $previous = null)
    {
        $this->model = $model;
        if ($message === null && $model) {
            $message = Utility::getModelErrorsString($model);
        }

        parent::__construct($message, $code, $previous);
    }

    public function getModel()
    {
        return $this->model;
    }
}