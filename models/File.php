<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;

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
            [['name', 'path'], 'string', 'length' => [1, 255]],
            [['path'], 'unique'],
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
            'path' => 'Путь',
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
        return $alias . '/' . $this->path;
    }

    public function getCanView()
    {
        return !Yii::$app->user->isGuest && (Yii::$app->user->identity->id === $this->user || Yii::$app->user->identity->isAdmin);
    }

    public function getCanUpdate()
    {
        return !Yii::$app->user->isGuest && (Yii::$app->user->identity->id === $this->user || Yii::$app->user->identity->isAdmin);
    }

    public function getCanDelete()
    {
        return !Yii::$app->user->isGuest && (Yii::$app->user->identity->id === $this->user || Yii::$app->user->identity->isAdmin);
    }
}
