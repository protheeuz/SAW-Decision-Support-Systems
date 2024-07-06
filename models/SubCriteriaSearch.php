<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SubCriteria;

class SubCriteriaSearch extends SubCriteria
{
    public function rules()
    {
        return [
            [['id', 'id_criteria', 'weight_hr', 'weight_pmo', 'weight_pd'], 'integer'],
            [['name'], 'safe'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = SubCriteria::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'id_criteria' => $this->id_criteria,
            'weight_hr' => $this->weight_hr,
            'weight_pmo' => $this->weight_pmo,
            'weight_pd' => $this->weight_pd,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}