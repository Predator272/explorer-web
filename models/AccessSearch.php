<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * AccessSearch represents the model behind the search form of `app\models\Access`.
 */
class AccessSearch extends Access
{
    public function rules()
    {
        return [
            [['user'], 'string'],
            [['file', 'rule'], 'integer'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Access::find()->joinWith(['file0', 'user0'])->where(['file.id' => $this->file]);

        $dataProvider = new ActiveDataProvider(['query' => $query, 'sort' => ['defaultOrder' => ['user0.login' => SORT_ASC]]]);

        $dataProvider->sort->attributes['user0.login'] = ['asc' => ['login' => SORT_ASC], 'desc' => ['login' => SORT_DESC]];

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'user.login', $this->user]);
        $query->andFilterWhere(['access.rule' => $this->rule]);

        return $dataProvider;
    }
}
