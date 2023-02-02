<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\File;
use app\models\User;

class FileSearch extends File
{
    public function rules()
    {
        return [
            [['name', 'user', 'onUpdate'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'myFiles' => 'Мои файлы',
        ]);
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = File::find()->joinWith('user0');

        $dataProvider = new ActiveDataProvider(['query' => $query, 'sort' => ['defaultOrder' => ['name' => SORT_ASC]],]);

        $dataProvider->sort->attributes['user0.login'] = [
            'asc' => ['login' => SORT_ASC],
            'desc' => ['login' => SORT_DESC],
        ];

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'name', $this->name]);
        $query->andFilterWhere(['like', 'onUpdate', $this->onUpdate]);
        $query->andFilterWhere(['like', 'login', $this->user]);

        return $dataProvider;
    }
}
