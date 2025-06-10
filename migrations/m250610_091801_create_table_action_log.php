<?php

use yii\db\Migration;

class m250610_091801_create_table_action_log extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('action_log', [
            'id' => $this->primaryKey()->unsigned(),
            'entity' => $this->string()->notNull(),
            'entity_id' => $this->integer()->unsigned(),
            'action_id' => $this->integer()->unsigned()->notNull(),
            'user_id' => $this->integer()->unsigned(),
            'old_state' => 'LONGTEXT',
            'new_state' => 'LONGTEXT',
            'created_at' => $this->integer()->unsigned(),
        ]);

        $this->createIndex('idx_action_log_entity', 'action_log', ['entity', 'entity_id', 'action_id']);
        $this->createIndex('idx_action_log_user_id', 'action_log', ['user_id']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('action_log');
    }
}
