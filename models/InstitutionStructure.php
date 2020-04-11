<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
use app\assets\DataDefinition;
use yii\helpers\Html;
use app\models\FileType;

/**
 * This is the model class for table "institution_structure".
 *
 * @property int $id
 * @property string $institution_name
 * @property string $institution_acronym
 * @property string $code
 * @property int $parent_institution_structure_id
 * @property int $institution_type_id
 * @property int $is_active
 * @property string $phone
 * @property string $fax
 * @property string $email
 * @property string $website
 * @property string $post_office_box
 * @property string $region
 * @property string $country
 * @property string $logo
 * @property int $logo_file_id
 * @property string $logo2
 * @property int $logo2_file_id
 * @property int $created_by
 * @property string $created_at
 * @property int $updated_by
 * @property string $updated_at
 *
 * @property InstitutionType $institutionType
 */
class InstitutionStructure extends \yii\db\ActiveRecord {
    /*
     * Use this as `parent_institution_structure_id`
     * 
     *  for all Institution Structures with no parent
     */

    const NO_PARENT = 0;

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'institution_structure';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['institution_name', 'institution_acronym', 'code', 'institution_type_id', 'is_active', 'phone', 'fax', 'email', 'website', 'post_office_box', 'region', 'country', 'logo', 'logo2'], 'required'],
            [['parent_institution_structure_id', 'institution_type_id', 'is_active', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at','logo_file_id','logo2_file_id'], 'safe'],
            [['institution_name'], 'string', 'max' => 150],
            [['institution_acronym'], 'string', 'max' => 70],
            [['code'], 'string', 'max' => 40],
            [['phone', 'fax', 'email', 'website', 'post_office_box', 'region', 'country', 'logo', 'logo2'], 'string', 'max' => 100],
            [['code'], 'unique'],
            [['institution_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => InstitutionType::className(), 'targetAttribute' => ['institution_type_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'institution_name' => 'Name',
            'institution_acronym' => 'Acronym',
            'code' => 'Code',
            'parent_institution_structure_id' => 'Parent',
            'institution_type_id' => 'Type',
            'is_active' => 'Is Active',
            'phone' => 'Phone',
            'fax' => 'Fax',
            'email' => 'Email',
            'website' => 'Website',
            'post_office_box' => 'Post Office Box',
            'region' => 'Region',
            'country' => 'Country',
            'logo' => 'Logo',
            'logo2' => 'Logo2',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'updated_by' => 'Updated By',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInstitutionType() {
        return $this->hasOne(InstitutionType::className(), ['id' => 'institution_type_id']);
    }

    public function hasParent() {
        return $this->parent_institution_structure_id !== self::NO_PARENT;
    }

    public function getParent() {
        return self::findOne($this->parent_institution_structure_id);
    }

    public function getType() {
        return InstitutionType::findOne($this->institution_type_id);
    }

    public static function getParents() {
        $models = self::find()->where("id IN (SELECT parent_institution_structure_id FROM institution_structure)")->all();
        return array_merge([self::NO_PARENT => '--ROOT--'], ArrayHelper::map($models, 'id', 'institution_name'));
    }

    public function countChildren() {
        return self::find()
                        ->where(['parent_institution_structure_id' => $this->id])
                        ->count();
    }

    public function isParent() {
        return $this->countChildren() > 0;
    }

    public function getChildren() {
        return self::find()
                        ->where(['parent_institution_structure_id' => $this->id])
                        ->andWhere(['is_active' => DataDefinition::BOOLEAN_TYPE_YES])
                        ->all();
    }

    public function getChildCountLabel() {
        return $this->countChildren() === 1 ? 'Child' : 'Children';
    }

    public function printChildren($enableLinks = true) {
        if (!$this->isParent()) {
            echo $enableLinks ? "<li id='structure-$this->id'>" . Html::a($this->institution_name, ['view', 'id' => $this->id], ['target' => 'blank']) . "</li>" : "<li id='structure-$this->id' style='cursor:pointer'>$this->institution_name</li>";
            return;
        }

        echo "<ul>";
        echo "<li id='structure-$this->id' style='cursor:pointer'>";
        echo $enableLinks ? "<span style='font-weight:bold'>" . Html::a($this->institution_name, ['view', 'id' => $this->id], ['target' => 'blank']) . "</span> <span class='text-muted'>(" . $this->countChildren() . " " . $this->getChildCountLabel() . ")</span>" : "<span style='font-weight:bold' id='span-$this->id'>$this->institution_name" . "</span> <span class='text-muted'>(" . $this->countChildren() . " " . $this->getChildCountLabel() . ")</span>";
        echo "<ol>";
        foreach ($this->getChildren() as $child) {
            $child->printChildren($enableLinks);
        }
        echo "</ol>";

        echo "</li>";
        echo "</ul>";
    }

    public static function getStructures() {
        return array_merge([self::NO_PARENT => '--ROOT--'],ArrayHelper::map(self::find()->where(['is_active' => DataDefinition::BOOLEAN_TYPE_YES])->all(), 'id', 'institution_name'));
    }

    public static function getDefaultLogo() {
        return FileType::findOne(['code' => 'CODE_INSTITUTION_STRUCTURE_LOGOS'])->path . 'default-logo.jpg';
    }

}
