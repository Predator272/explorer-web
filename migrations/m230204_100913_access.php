<?php

use yii\db\Migration;

class m230204_100913_access extends Migration
{
    private const NAME = 'access';

    public function safeUp()
    {
        $this->createTable(static::NAME, [
            'id' => $this->bigPrimaryKey()->unsigned()->comment('ID'),
            'file' => $this->bigInteger()->unsigned()->notNull()->comment('Файл'),
            'user' => $this->bigInteger()->unsigned()->notNull()->comment('Пользователь'),
            'rule' => $this->tinyInteger()->unsigned()->notNull()->defaultValue(0)->comment('Тип'),
        ]);

        $this->createIndex('idx-access-file-user', static::NAME, ['file', 'user'], true);

        $this->addForeignKey('fk-access-file', static::NAME, 'file', 'file', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk-access-user', static::NAME, 'user', 'user', 'id', 'CASCADE', 'CASCADE');
    }

    public function safeDown()
    {
        $this->truncateTable(static::NAME);
        $this->dropForeignKey('fk-access-file', static::NAME);
        $this->dropForeignKey('fk-access-user', static::NAME);
        $this->dropIndex('idx-access-file-user', static::NAME);
        $this->dropTable(static::NAME);
    }
}
