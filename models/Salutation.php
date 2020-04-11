<?php

namespace app\models;

use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "salutation".
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int $is_active
 * @property string $created_at
 * @property int $created_by
 * @property string $updated_at
 * @property int $updated_by
 */
class Salutation extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'salutation';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['name', 'description'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['created_by', 'updated_by', 'is_active'], 'integer'],
            [['name'], 'string', 'max' => 5],
            [['description'], 'string', 'max' => 128],
            [['name'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'description' => 'Description',
            'is_active' => 'Is Active',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }

    public static function getSalutations() {
        return ArrayHelper::map(self::find()->select(['id', 'name'])->all(), 'id', 'name');
    }

    public function countUses() {
        return User::find()->where(['salutation_id' => $this->id])->count() + Employee::find()->where(['salutation_id' => $this->id])->count();
    }

    public function everUsed() {
        return $this->countUses() > 0;
    }

    public function canBeDeleted() {
        return !$this->everUsed();
    }

}
