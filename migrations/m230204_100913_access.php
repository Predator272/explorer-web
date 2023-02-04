<?php

use yii\db\Migration;

class m230204_100913_access extends Migration
{
    private const NAME = 'access';

    public function safeUp()
    {
        $this->createTable(static::NAME, [
            'id' => $this->bigPrimaryKey()->unsigned(),
            'file' => $this->bigInteger()->unsigned()->notNull(),
            'user' => $this->bigInteger()->unsigned()->notNull(),
            'flag' => $this->tinyInteger()->unsigned()->notNull()->defaultValue(0),
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
