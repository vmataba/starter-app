<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\InstitutionStructure;

/**
 * InstitutionStructureSearch represents the model behind the search form of `app\models\InstitutionStructure`.
 */
class InstitutionStructureSearch extends InstitutionStructure
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'parent_institution_structure_id', 'institution_type_id', 'is_active', 'created_by', 'updated_by'], 'integer'],
            [['institution_name', 'institution_acronym', 'code', 'phone', 'fax', 'email', 'website', 'post_office_box', 'region', 'country', 'logo', 'logo2', 'created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = InstitutionStructure::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'parent_institution_structure_id' => $this->parent_institution_structure_id,
            'institution_type_id' => $this->institution_type_id,
            'is_active' => $this->is_active,
            'created_by' => $this->created_by,
            'created_at' => $this->created_at,
            'updated_by' => $this->updated_by,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'institution_name', $this->institution_name])
            ->andFilterWhere(['like', 'institution_acronym', $this->institution_acronym])
            ->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'fax', $this->fax])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'website', $this->website])
            ->andFilterWhere(['like', 'post_office_box', $this->post_office_box])
            ->andFilterWhere(['like', 'region', $this->region])
            ->andFilterWhere(['like', 'country', $this->country])
            ->andFilterWhere(['like', 'logo', $this->logo])
            ->andFilterWhere(['like', 'logo2', $this->logo2]);

        return $dataProvider;
    }
}
