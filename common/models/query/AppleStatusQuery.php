<?php

namespace common\models\query;

use common\models\AppleStatus;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[AppleStatus]].
 *
 * @see AppleStatus
 */
class AppleStatusQuery extends ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return AppleStatus[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return AppleStatus|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
