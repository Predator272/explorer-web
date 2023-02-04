<?php

use yii\db\Migration;

class m230204_091740_user extends Migration
{
    private const NAME = 'user';

    public function safeUp()
    {
        $this->createTable(static::NAME, [
            'id' => $this->bigPrimaryKey()->unsigned(),
            'login' => $this->string(255)->notNull()->unique(),
            'password' => $this->string(255)->notNull(),
            'rule' => $this->tinyInteger()->unsigned()->notNull()->defaultValue(0),
        ]);

        $this->insert(static::NAME, ['login' => 'admin@mail.ru', 'password' => md5('admin'), 'rule' => 1]);
    }

    public function safeDown()
    {
        $this->truncateTable(static::NAME);
        $this->dropTable(static::NAME);
    }
}
