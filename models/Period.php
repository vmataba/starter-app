<?php

namespace app\models;

use Yii;
use app\assets\DataDefinition;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "period".
 *
 * @property int $id
 * @property string $code
 * @property string $name
 * @property int $time_unit_id
 * @property double $weight
 * @property int $is_active
 * @property string $created_at
 * @property int $created_by
 * @property string $updated_at
 * @property int $updated_by
 */
class Period extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'period';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['code', 'name', 'time_unit_id', 'weight', 'is_active', 'created_at'], 'required'],
            [['time_unit_id', 'is_active', 'created_by', 'updated_by'], 'integer'],
            [['weight'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['code'], 'string', 'max' => 128],
            [['name'], 'string', 'max' => 50],
            [['code', 'name'], 'unique'],
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
            'time_unit_id' => 'Time Unit',
            'weight' => 'Weight',
            'is_active' => 'Is Active',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }

    public function getTimeUnit() {
        $model = TimeUnit::findOne($this->time_unit_id);
        return $model;
    }

    public function getPrettyWeight() {
        if ((int) $this->weight === 1) {
            return "$this->weight " . $this->getTimeUnit()->name;
        }
        return "$this->weight " . $this->getTimeUnit()->name . "s";
    }

    public static function getPeriods() {
        $models = self::find()->where(['is_active' => DataDefinition::BOOLEAN_TYPE_YES])->all();
        return ArrayHelper::map($models, 'id', 'name');
    }

}
