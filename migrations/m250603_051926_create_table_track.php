<?php

use yii\db\Migration;

class m250603_051926_create_table_track extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('track', [
           'id' => $this->primaryKey(),
           'track_number' => $this->string('255')->notNull()->unique(),
           'status' => $this->integer()->notNull()->defaultValue(0),
           'created_at' => $this->integer()->notNull(),
           'updated_at' => $this->integer()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('track');
    }
}
