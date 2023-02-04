<?php

use yii\db\Migration;

class m230204_092923_file extends Migration
{
    private const NAME = 'file';

    public function safeUp()
    {
        $this->createTable(static::NAME, [
            'id' => $this->bigPrimaryKey()->unsigned(),
            'name' => $this->string(255)->notNull(),
            'user' => $this->bigInteger()->unsigned()->notNull(),
            'path' => $this->string(255)->notNull(),
            'onUpdate' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP')->append('ON UPDATE CURRENT_TIMESTAMP'),
        ]);

        $this->addForeignKey('fk-file-user', static::NAME, 'user', 'user', 'id', 'CASCADE', 'CASCADE');
    }

    public function safeDown()
    {
        $this->truncateTable(static::NAME);
        $this->dropForeignKey('fk-file-user', static::NAME);
        $this->dropTable(static::NAME);
    }
}
