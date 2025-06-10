<?php

use yii\db\Migration;

class m250610_071511_create_table_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('user', [
            'id' => $this->primaryKey()->unsigned(),
            'email' => $this->string(45)->notNull(),
            'phone' => $this->string(45),
            'name' => $this->string(45),
            'surname' => $this->string(45),
            'patronymic' => $this->string(45),
            'auth_key' => $this->string(32),
            'password_hash' => $this->string(60),
            'access_token' => $this->string(36),
            'recovery_token' => $this->string(36),
            'recovery_sent_at' => $this->integer()->unsigned(),
            'is_deleted' => $this->tinyInteger(1)->unsigned()->notNull()->defaultValue(0),
            'is_active' => $this->tinyInteger(1)->unsigned()->notNull()->defaultValue(1),
            'created_at' => $this->integer()->unsigned(),
            'updated_at' => $this->integer()->unsigned(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250610_071511_create_table_user cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250610_071511_create_table_user cannot be reverted.\n";

        return false;
    }
    */
}
