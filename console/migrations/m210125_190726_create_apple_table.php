<?php

use common\models\AppleStatus;
use yii\db\Migration;

/**
 * Handles the creation of table `{{%apple}}`.
 */
class m210125_190726_create_apple_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%apple}}', [
            'id' => $this->primaryKey(),
            'color' => $this->string(),
            'date_created' => $this->dateTime()->notNull(),
            'date_drop' => $this->dateTime(),
            'integrity' => $this->integer()->notNull(),
            'status_id' => $this->integer()->notNull()
        ]);

        $this->addForeignKey(
            'fk-apple-status_id-apple_status-id',
            'apple',
            'status_id',
            'apple_status',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'fk-apple-status_id-apple_status-id',
            'apple',
        );

        $this->dropTable('{{%apple}}');
    }
}
