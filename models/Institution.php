<?php

namespace app\models;

/**
 * This is the model class for table "institution".
 *
 * @property int $id
 * @property string $institution_code
 * @property int $subsp_code
 * @property string $institution_name
 * @property string $logo
 * @property int $logo_file_id
 * @property double $logo_height
 * @property double $logo_width
 * @property string $banner
 * @property string $instructions
 * @property string $instructions_pg
 * @property string $contact_details
 * @property string $home_page
 * @property string $pay_bank_instructions
 * @property string $pay_bank_instructions_pg
 * @property int $min_prog_direct
 * @property int $max_prog_direct
 * @property int $min_prog_equivalent
 * @property int $max_prog_equivalent
 * @property int $min_programme
 * @property int $max_programme
 * @property string $support_email1
 * @property string $support_email2
 * @property string $support_email3
 * @property string $support_phone1
 * @property string $support_phone2
 * @property string $support_phone3
 * @property string $applicant_home_page
 * @property string $application_deadline
 * @property string $activate_account_email
 * @property string $referee_email
 * @property string $application_close_reminder
 * @property string $not_selected_email
 * @property string $selected_email
 * @property string $payment_confirmed_email
 * @property string $account_activated_message
 * @property string $banner_color
 * @property int $application_status 1 applications are opened, 2 registration are closed but application can be modified, 3 registration/application is closed
 * @property string $application_status_remarks
 * @property int $application_status_pg 1=>Applications are opened, 2=>Applications are closed
 * @property string $application_status_remarks_pg
 * @property string $tcu_username
 * @property string $tcu_key
 * @property int $current_round
 * @property int $confirmation_status
 * @property string $admiss_letter_ug
 * @property string $admiss_letter_pg
 * @property int $publish_status_pg 0 admissions are not published, 1 admissions are published
 * @property int $show_pg_tab
 * @property string $created_at
 * @property int $closed_by
 * @property string $updated_at
 * @property int $updated_by
 */
class Institution extends \yii\db\ActiveRecord {

    const DEFAULT_LOGO_WIDTH = "160px";
    const DEFAULT_LOGO_HEIGHT = "170px";

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'institution';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['subsp_code', 'logo_height', 'logo_width'], 'required'],
            [['subsp_code', 'min_prog_direct', 'max_prog_direct', 'min_prog_equivalent', 'max_prog_equivalent', 'min_programme', 'max_programme', 'application_status', 'application_status_pg', 'current_round', 'confirmation_status', 'publish_status_pg', 'show_pg_tab', 'closed_by', 'updated_by', 'logo_file_id'], 'integer'],
            [['logo_height', 'logo_width'], 'number'],
            [['instructions', 'instructions_pg', 'contact_details', 'home_page', 'pay_bank_instructions', 'pay_bank_instructions_pg', 'applicant_home_page', 'activate_account_email', 'referee_email', 'application_close_reminder', 'not_selected_email', 'selected_email', 'payment_confirmed_email', 'account_activated_message', 'admiss_letter_ug', 'admiss_letter_pg'], 'string'],
            [['application_deadline', 'created_at', 'updated_at'], 'safe'],
            [['institution_code', 'support_phone1', 'support_phone2', 'support_phone3'], 'string', 'max' => 20],
            [['institution_name', 'support_email1', 'support_email2', 'support_email3'], 'string', 'max' => 100],
            [['logo', 'banner'], 'string', 'max' => 255],
            [['banner_color'], 'string', 'max' => 40],
            [['application_status_remarks', 'application_status_remarks_pg'], 'string', 'max' => 1000],
            [['tcu_username'], 'string', 'max' => 10],
            [['tcu_key'], 'string', 'max' => 400],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'institution_code' => 'Institution Code',
            'subsp_code' => 'Subsp Code',
            'institution_name' => 'Institution Name',
            'logo' => 'Logo',
            'logo_height' => 'Logo Height',
            'logo_width' => 'Logo Width',
            'banner' => 'Banner',
            'instructions' => 'Instructions',
            'instructions_pg' => 'Instructions Pg',
            'contact_details' => 'Contact Details',
            'home_page' => 'Home Page',
            'pay_bank_instructions' => 'Pay Bank Instructions',
            'pay_bank_instructions_pg' => 'Pay Bank Instructions Pg',
            'min_prog_direct' => 'Min Prog Direct',
            'max_prog_direct' => 'Max Prog Direct',
            'min_prog_equivalent' => 'Min Prog Equivalent',
            'max_prog_equivalent' => 'Max Prog Equivalent',
            'min_programme' => 'Min Programme',
            'max_programme' => 'Max Programme',
            'support_email1' => 'Support Email1',
            'support_email2' => 'Support Email2',
            'support_email3' => 'Support Email3',
            'support_phone1' => 'Support Phone1',
            'support_phone2' => 'Support Phone2',
            'support_phone3' => 'Support Phone3',
            'applicant_home_page' => 'Applicant Home Page',
            'application_deadline' => 'Application Deadline',
            'activate_account_email' => 'Activate Account Email',
            'referee_email' => 'Referee Email',
            'application_close_reminder' => 'Application Close Reminder',
            'not_selected_email' => 'Not Selected Email',
            'selected_email' => 'Selected Email',
            'payment_confirmed_email' => 'Payment Confirmed Email',
            'account_activated_message' => 'Account Activated Message',
            'banner_color' => 'Banner Color',
            'application_status' => 'Application Status',
            'application_status_remarks' => 'Application Status Remarks',
            'application_status_pg' => 'Application Status Pg',
            'application_status_remarks_pg' => 'Application Status Remarks Pg',
            'tcu_username' => 'Tcu Username',
            'tcu_key' => 'Tcu Key',
            'current_round' => 'Current Round',
            'confirmation_status' => 'Confirmation Status',
            'admiss_letter_ug' => 'Admiss Letter Ug',
            'admiss_letter_pg' => 'Admiss Letter Pg',
            'publish_status_pg' => 'Publish Status Pg',
            'show_pg_tab' => 'Show Pg Tab',
            'created_at' => 'Created At',
            'closed_by' => 'Closed By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }

    public static function countInstances() {
        return self::find()->count();
    }

    public static function hasInstance() {
        return self::countInstances() !== 0;
    }

    public static function getInstance() {
        return self::find()->one();
    }

    public static function getDefaultLogo() {
        return InstitutionStructure::getDefaultLogo();
    }

    public static function getDisplayName() {
        $institution = self::getInstance();
        return "$institution->institution_name ($institution->institution_code)";
    }

}
