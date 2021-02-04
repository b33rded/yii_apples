<?php

namespace common\models;

use common\models\query\AppleStatusQuery;
use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "apple_status".
 *
 * @property int $id
 * @property string $name
 * @property string|null $code
 *
 * @property Apple[] $apples
 */
class AppleStatus extends ActiveRecord
{
    public const ON_TREE = 'on_tree';
    public const ON_GROUND = 'on_ground';
    public const ROTTEN = 'rotten';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'apple_status';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['code'], 'default', 'value' => null],
            [['name', 'code'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'code' => 'Code',
        ];
    }

    /**
     * Gets query for [[Apple]].
     *
     * @return ActiveQuery|AppleStatusQuery
     */
    public function getApples()
    {
        return $this->hasMany(Apple::class, ['id' => 'status_id']);
    }

    /**
     * {@inheritdoc}
     * @return AppleStatusQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AppleStatusQuery(get_called_class());
    }

    public static function getByCode(string $code): self
    {
        return self::findOne(['code' => $code]);
    }

    public static function getIdByCode(string $code): int
    {
        return self::findOne(['code' => $code])->id;
    }

    public static function exceptRotten($db = null): ActiveQuery
    {
        return self::find()
            ->andWhere(
                ['OR',
                    ['code' => AppleStatus::ON_TREE],
                    ['code' => AppleStatus::ON_GROUND]
                ]);
    }
}
