<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * SignupForm is the model behind the signup form.
 *
 * @property-read User|null $user
 *
 */
class SignupForm extends Model
{
    public $login;
    public $password;
    public $passwordConfirm;

    public function rules()
    {
        return [
            [['login', 'password', 'passwordConfirm'], 'required'],
            [['login', 'password', 'passwordConfirm'], 'string', 'length' => [4, 255]],
            [['login'], 'email'],
            [['login'], 'unique', 'targetClass' => User::class],
            [['passwordConfirm'], 'compare', 'compareAttribute' => 'password'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'login' => 'Логин',
            'password' => 'Пароль',
            'passwordConfirm' => 'Подтвердите пароль',
        ];
    }

    public function signup()
    {
        if ($this->validate()) {
            $model = new User(['login' => $this->login, 'password' => $this->password]);
            return ($model->save() && Yii::$app->user->login($model, 3600 * 24 * 30));
        }
        return false;
    }
}
