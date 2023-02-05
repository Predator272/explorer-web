<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "access".
 *
 * @property int $id ID
 * @property int $file Файл
 * @property int $user Пользователь
 * @property int $rule Параметры
 *
 * @property File $file0
 * @property User $user0
 */
class Access extends ActiveRecord
{
    public static function tableName()
    {
        return 'access';
    }

    public function rules()
    {
        return [
            [['file', 'user'], 'required'],
            [['file', 'user', 'rule'], 'integer'],
            [['file', 'user'], 'unique', 'targetAttribute' => ['file', 'user']],
            [['file'], 'exist', 'skipOnError' => true, 'targetClass' => File::class, 'targetAttribute' => ['file' => 'id']],
            [['user'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'file' => 'Файл',
            'user' => 'Пользователь',
            'rule' => 'Параметры',
        ];
    }

    public function getFile0()
    {
        return $this->hasOne(File::class, ['id' => 'file']);
    }

    public function getUser0()
    {
        return $this->hasOne(User::class, ['id' => 'user']);
    }
}
