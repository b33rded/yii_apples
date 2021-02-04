<?php

namespace common\models;

use common\components\Utility;
use common\models\query\AppleQuery;
use common\models\query\AppleStatusQuery;
use yii\base\Event;
use yii\behaviors\AttributeBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property string|null $color
 * @property string $date_created
 * @property string|null $date_drop
 * @property int $integrity
 * @property int $status_id
 *
 * @property AppleStatus $status
 */

class Apple extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'apple';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['integrity', 'status_id'], 'required'],
            [['date_created', 'date_drop', 'color'], 'safe'],
            [['status_id'], 'default', 'value' => AppleStatus::ON_TREE],
            [['integrity', 'status_id',], 'integer'],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => AppleStatus::class, 'targetAttribute' => ['status_id' => 'id']],
        ];
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'date_created',
                'updatedAtAttribute' => false,
                'value' => Utility::getDateNow(),
            ],
            'color' => [
                'class' => AttributeBehavior::class,
                'value' => function (Event $event) {
                    return sprintf('#%06X', mt_rand(0, 0xFFFFFF));
                },
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'color',
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'color' => 'Цвет',
            'date_created' => 'Дата появления',
            'date_drop' => 'Дата падения',
            'integrity' => 'Целостность',
            'status_id' => 'Статус',
            'apple_status' => 'Находится',
            'bitePercent' => 'Сколько откушено',
        ];
    }

    /**
     * Gets query for [[Status]].
     *
     * @return ActiveQuery|AppleStatusQuery
     */
    public function getStatus()
    {
        return $this->hasOne(AppleStatus::class, ['id' => 'status_id']);
    }


    /**
     * {@inheritdoc}
     * @return AppleQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AppleQuery(get_called_class());
    }
}
