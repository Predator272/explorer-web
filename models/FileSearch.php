<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class FileSearch extends File
{
    public function rules()
    {
        return [
            [['name', 'user', 'onUpdate'], 'string', 'max' => 255],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = File::find()->joinWith(['user0', 'accesses'])->where(['or', ['file.user' => Yii::$app->user->identity->id], ['access.user' => Yii::$app->user->identity->id]]);

        $dataProvider = new ActiveDataProvider(['query' => $query, 'sort' => ['defaultOrder' => ['name' => SORT_ASC]]]);

        $dataProvider->sort->attributes['user0.login'] = ['asc' => ['login' => SORT_ASC], 'desc' => ['login' => SORT_DESC]];

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'file.name', $this->name]);
        $query->andFilterWhere(['like', 'file.onUpdate', $this->onUpdate]);
        $query->andFilterWhere(['like', 'user.login', $this->user]);

        return $dataProvider;
    }
}
