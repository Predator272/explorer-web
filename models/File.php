<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "file".
 *
 * @property int $id ID
 * @property string $name Имя
 * @property int $user Владелец
 * @property string $path Путь
 * @property string $onUpdate Дата изменения
 *
 * @property Access[] $accesses
 * @property User $user0
 * @property User[] $users
 */
class File extends ActiveRecord
{
    public static function tableName()
    {
        return 'file';
    }

    public function rules()
    {
        return [
            [['user'], 'integer'],
            [['onUpdate'], 'safe'],
            [['name'], 'string', 'length' => [1, 255]],
            [['name', 'user'], 'unique', 'targetAttribute' => ['name', 'user']],
            [['user'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user' => 'id']],

            [['name'], 'trim'],
            [['name'], 'match', 'pattern' => '/^[^\\\\\/:*?"<>|]+$/'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Имя',
            'user' => 'Владелец',
            'onUpdate' => 'Дата изменения',
        ];
    }

    public function getAccesses()
    {
        return $this->hasMany(Access::class, ['file' => 'id']);
    }

    public function getUser0()
    {
        return $this->hasOne(User::class, ['id' => 'user']);
    }

    public function getUsers()
    {
        return $this->hasMany(User::class, ['id' => 'user'])->viaTable('access', ['file' => 'id']);
    }

    public function getFilePath()
    {
        $alias = Yii::getAlias('@app/files');
        if (!is_dir($alias)) {
            mkdir($alias);
        }
        return "$alias/$this->id";
    }

    public function getAllowedUsers()
    {
        return ArrayHelper::map(ArrayHelper::toArray($this->accesses, [Access::class => ['user', 'rule']]), 'user', 'rule');
    }

    public function getCanView()
    {
        $allow = ArrayHelper::keyExists(Yii::$app->user->identity->id, $this->allowedUsers) && $this->allowedUsers[Yii::$app->user->identity->id] >= 0;

        return !Yii::$app->user->isGuest && (Yii::$app->user->identity->id === $this->user || Yii::$app->user->identity->isAdmin || $allow);
    }

    public function getCanUpdate()
    {
        $allow = ArrayHelper::keyExists(Yii::$app->user->identity->id, $this->allowedUsers) && $this->allowedUsers[Yii::$app->user->identity->id] >= 1;

        return !Yii::$app->user->isGuest && (Yii::$app->user->identity->id === $this->user || Yii::$app->user->identity->isAdmin || $allow);
    }

    public function getCanDelete()
    {
        $allow = ArrayHelper::keyExists(Yii::$app->user->identity->id, $this->allowedUsers) && $this->allowedUsers[Yii::$app->user->identity->id] >= 2;

        return !Yii::$app->user->isGuest && (Yii::$app->user->identity->id === $this->user || Yii::$app->user->identity->isAdmin || $allow);
    }
}
