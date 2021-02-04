<?php

namespace common\models\query;

use common\models\Apple;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[\common\models\Apple]].
 *
 * @see \common\models\Apple
 */
class AppleQuery extends ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Apple[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Apple|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
