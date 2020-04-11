<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Institution;

/**
 * InstitutionSearch represents the model behind the search form of `app\models\Institution`.
 */
class InstitutionSearch extends Institution
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'subsp_code', 'min_prog_direct', 'max_prog_direct', 'min_prog_equivalent', 'max_prog_equivalent', 'min_programme', 'max_programme', 'application_status', 'application_status_pg', 'current_round', 'confirmation_status', 'publish_status_pg', 'show_pg_tab', 'closed_by', 'updated_by'], 'integer'],
            [['institution_code', 'institution_name', 'logo', 'banner', 'instructions', 'instructions_pg', 'contact_details', 'home_page', 'pay_bank_instructions', 'pay_bank_instructions_pg', 'support_email1', 'support_email2', 'support_email3', 'support_phone1', 'support_phone2', 'support_phone3', 'applicant_home_page', 'application_deadline', 'activate_account_email', 'referee_email', 'application_close_reminder', 'not_selected_email', 'selected_email', 'payment_confirmed_email', 'account_activated_message', 'banner_color', 'application_status_remarks', 'application_status_remarks_pg', 'tcu_username', 'tcu_key', 'admiss_letter_ug', 'admiss_letter_pg', 'created_at', 'updated_at'], 'safe'],
            [['logo_height', 'logo_width'], 'number'],
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
        $query = Institution::find();

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
            'subsp_code' => $this->subsp_code,
            'logo_height' => $this->logo_height,
            'logo_width' => $this->logo_width,
            'min_prog_direct' => $this->min_prog_direct,
            'max_prog_direct' => $this->max_prog_direct,
            'min_prog_equivalent' => $this->min_prog_equivalent,
            'max_prog_equivalent' => $this->max_prog_equivalent,
            'min_programme' => $this->min_programme,
            'max_programme' => $this->max_programme,
            'application_deadline' => $this->application_deadline,
            'application_status' => $this->application_status,
            'application_status_pg' => $this->application_status_pg,
            'current_round' => $this->current_round,
            'confirmation_status' => $this->confirmation_status,
            'publish_status_pg' => $this->publish_status_pg,
            'show_pg_tab' => $this->show_pg_tab,
            'created_at' => $this->created_at,
            'closed_by' => $this->closed_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'institution_code', $this->institution_code])
            ->andFilterWhere(['like', 'institution_name', $this->institution_name])
            ->andFilterWhere(['like', 'logo', $this->logo])
            ->andFilterWhere(['like', 'banner', $this->banner])
            ->andFilterWhere(['like', 'instructions', $this->instructions])
            ->andFilterWhere(['like', 'instructions_pg', $this->instructions_pg])
            ->andFilterWhere(['like', 'contact_details', $this->contact_details])
            ->andFilterWhere(['like', 'home_page', $this->home_page])
            ->andFilterWhere(['like', 'pay_bank_instructions', $this->pay_bank_instructions])
            ->andFilterWhere(['like', 'pay_bank_instructions_pg', $this->pay_bank_instructions_pg])
            ->andFilterWhere(['like', 'support_email1', $this->support_email1])
            ->andFilterWhere(['like', 'support_email2', $this->support_email2])
            ->andFilterWhere(['like', 'support_email3', $this->support_email3])
            ->andFilterWhere(['like', 'support_phone1', $this->support_phone1])
            ->andFilterWhere(['like', 'support_phone2', $this->support_phone2])
            ->andFilterWhere(['like', 'support_phone3', $this->support_phone3])
            ->andFilterWhere(['like', 'applicant_home_page', $this->applicant_home_page])
            ->andFilterWhere(['like', 'activate_account_email', $this->activate_account_email])
            ->andFilterWhere(['like', 'referee_email', $this->referee_email])
            ->andFilterWhere(['like', 'application_close_reminder', $this->application_close_reminder])
            ->andFilterWhere(['like', 'not_selected_email', $this->not_selected_email])
            ->andFilterWhere(['like', 'selected_email', $this->selected_email])
            ->andFilterWhere(['like', 'payment_confirmed_email', $this->payment_confirmed_email])
            ->andFilterWhere(['like', 'account_activated_message', $this->account_activated_message])
            ->andFilterWhere(['like', 'banner_color', $this->banner_color])
            ->andFilterWhere(['like', 'application_status_remarks', $this->application_status_remarks])
            ->andFilterWhere(['like', 'application_status_remarks_pg', $this->application_status_remarks_pg])
            ->andFilterWhere(['like', 'tcu_username', $this->tcu_username])
            ->andFilterWhere(['like', 'tcu_key', $this->tcu_key])
            ->andFilterWhere(['like', 'admiss_letter_ug', $this->admiss_letter_ug])
            ->andFilterWhere(['like', 'admiss_letter_pg', $this->admiss_letter_pg]);

        return $dataProvider;
    }
}
