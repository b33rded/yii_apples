<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%apple}}`.
 */
class m210125_190112_create_apple_status_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%apple_status}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'code' => $this->string()
        ]);

        $statuses = [
            'rotten' => 'Сгнило',
            'on_tree' => 'На дереве',
            'on_ground' => 'Упало',
        ];

        foreach ($statuses as $code => $name) {
            $this->insert('apple_status', [
                'code' => $code,
                'name' => $name
            ]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%apple_status}}');
    }
}
