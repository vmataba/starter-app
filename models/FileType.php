<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "file_type".
 *
 * @property int $id
 * @property string $code
 * @property string $name
 * @property string $description
 * @property string $path
 * @property string $accepted_types
 * @property int $is_active
 * @property string $created_at
 * @property int $created_by
 * @property string $updated_at
 * @property int $updated_by
 */
class FileType extends \yii\db\ActiveRecord {

    const CODE_PROFILE_PICTURE = 'CODE_PROFILE_PICTURE';
    const CODE_EMPLOYEE_PICTURE = 'CODE_EMPLOYEE_PICTURE';
    const CODE_CUSTOMER_PICTURE = 'CODE_CUSTOMER_PICTURE';
    const CODE_INSTITUTION_STRUCTURE_LOGOS = 'CODE_INSTITUTION_STRUCTURE_LOGOS';
    const CODE_EMPLOYEE_PICTURES = 'CODE_EMPLOYEE_PICTURES';
    const CODE_EMPLOYEE_CONTRACTS = 'CODE_EMPLOYEE_CONTRACTS';
    const CODE_INSTITUTION_LOGOS = 'CODE_INSTITUTION_LOGOS';
    const CODE_SALARY_DISTRIBUTION_SUPPORTING_DOCUMENT = 'CODE_SALARY_DISTRIBUTION_SUPPORTING_DOCUMENT';

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'file_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['code', 'name', 'description', 'path', 'accepted_types'], 'required'],
            [['is_active', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['code', 'name'], 'string', 'max' => 128],
            [['description', 'path', 'accepted_types'], 'string', 'max' => 512],
            [['code'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'code' => 'Code',
            'name' => 'Name',
            'description' => 'Description',
            'path' => 'Path',
            'accepted_types' => 'Accepted Types',
            'is_active' => 'Is Active',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }

}
