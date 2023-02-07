<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property int $id ID
 * @property string $login Логин
 * @property string $password Пароль
 * @property int $rule Тип
 *
 * @property Access[] $accesses
 * @property File[] $files
 * @property File[] $files0
 */
class User extends ActiveRecord implements IdentityInterface
{
    public static function tableName()
    {
        return 'user';
    }

    public function rules()
    {
        return [
            [['login', 'password'], 'required'],
            [['rule'], 'integer'],
            [['login', 'password'], 'string', 'max' => 255],
            [['login'], 'unique'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'login' => 'Логин',
            'password' => 'Пароль',
            'rule' => 'Тип',
        ];
    }

    public function getAccesses()
    {
        return $this->hasMany(Access::class, ['user' => 'id']);
    }

    public function getFiles()
    {
        return $this->hasMany(File::class, ['user' => 'id']);
    }

    public function getFiles0()
    {
        return $this->hasMany(File::class, ['id' => 'file'])->viaTable('access', ['user' => 'id']);
    }

    public static function findByLogin($login)
    {
        return static::findOne(['login' => $login]);
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return null;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return null;
    }

    public function validateAuthKey($authKey)
    {
        return null;
    }

    public function validatePassword($password)
    {
        return $this->password === md5($password);;
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->validatePassword($this->password) === false) {
                $this->password = md5($this->password);
            }
            return true;
        }
        return false;
    }

    public function getIsAdmin()
    {
        return $this->rule === 1;
    }
}
