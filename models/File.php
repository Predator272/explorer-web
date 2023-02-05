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
 *
 * @property Access[] $accesses
 * @property User $user0
 * @property User[] $users
 */
class File extends ActiveRecord
{
    public $file;

    public static function tableName()
    {
        return 'file';
    }

    public function rules()
    {
        return [
            [['user'], 'integer'],
            [['onUpdate'], 'safe'],
            [['name'], 'default', 'value' => 'unnamed'],
            [['name'], 'trim'],
            [['name', 'path'], 'string', 'max' => 255],
            [['user'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user' => 'id']],
            [['name'], 'match', 'pattern' => '/^[^\\\\\/:*?"<>|]+$/', 'message' => 'Некорректное имя файла.'],
            [['file'], 'file'],
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
            'file' => 'Файл',
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

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->user = Yii::$app->user->identity->id;
                $this->path = Yii::$app->security->generateRandomString(64);
            }
            if ($file = UploadedFile::getInstance($this, 'file')) {
                $this->name = $file->name;
                return $file->saveAs($this->filePath);
            }
            return true;
        }
        return false;
    }

    public function beforeDelete()
    {
        if (parent::beforeDelete()) {
            if (is_file($this->filePath)) {
                unlink($this->filePath);
            }
            return true;
        }
        return false;
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
