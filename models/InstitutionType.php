<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
use app\assets\DataDefinition;
/**
 * This is the model class for table "institution_type".
 *
 * @property int $id
 * @property string $institution_type_name
 * @property int $rank
 * @property int $is_active
 * @property int $created_by
 * @property string $created_at
 * @property int $updated_by
 * @property string $updated_at
 *
 * @property InstitutionStructure[] $institutionStructures
 */
class InstitutionType extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'institution_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['institution_type_name', 'rank', 'is_active'], 'required'],
            [['rank', 'is_active', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['rank'],'unique'],
            [['institution_type_name'], 'string', 'max' => 150],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'institution_type_name' => 'Institution Type Name',
            'rank' => 'Rank',
            'is_active' => 'Is Active',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'updated_by' => 'Updated By',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInstitutionStructures() {
        return $this->hasMany(InstitutionStructure::className(), ['institution_type_id' => 'id']);
    }
    
    public static function getTypes(){
        return ArrayHelper::map(self::find()->where(['is_active' => DataDefinition::BOOLEAN_TYPE_YES])->all(), 'id', 'institution_type_name');
    }

}
