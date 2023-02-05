<?php

use yii\db\Migration;

class m230204_092923_file extends Migration
{
    private const NAME = 'file';

    public function safeUp()
    {
        $this->createTable(static::NAME, [
            'id' => $this->bigPrimaryKey()->unsigned()->comment('ID'),
            'name' => $this->string(255)->notNull()->comment('Имя'),
            'user' => $this->bigInteger()->unsigned()->notNull()->comment('Владелец'),
            'onUpdate' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP')->append('ON UPDATE CURRENT_TIMESTAMP')->comment('Дата изменения'),
        ]);

        $this->createIndex('idx-file-name-user', static::NAME, ['name', 'user'], true);

        $this->addForeignKey('fk-file-user', static::NAME, 'user', 'user', 'id', 'CASCADE', 'CASCADE');
    }

    public function safeDown()
    {
        $this->truncateTable(static::NAME);
        $this->dropForeignKey('fk-file-user', static::NAME);
        $this->dropIndex('idx-file-name-user', static::NAME);
        $this->dropTable(static::NAME);
    }
}
