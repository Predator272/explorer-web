<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "access".
 *
 * @property int $id ID
 * @property int $file Файл
 * @property int $user Пользователь
 * @property int $rule Тип
 *
 * @property File $file0
 * @property User $user0
 */
class Access extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'access';
    }

    /**
     * {@inheritdoc}
     */
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

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'file' => 'Файл',
            'user' => 'Пользователь',
            'rule' => 'Тип',
        ];
    }

    /**
     * Gets query for [[File0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFile0()
    {
        return $this->hasOne(File::class, ['id' => 'file']);
    }

    /**
     * Gets query for [[User0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser0()
    {
        return $this->hasOne(User::class, ['id' => 'user']);
    }
}
