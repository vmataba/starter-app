<?php

namespace app\models;

use app\assets\DataDefinition;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "identity_type".
 *
 * @property int $id
 * @property string $code
 * @property string $name
 * @property int $is_active
 * @property string $created_at
 * @property int $created_by
 * @property string $updated_at
 * @property int $updated_by
 */
class IdentityType extends \yii\db\ActiveRecord {

    const NUMBERS_COUNT_IN_CODE = 2;

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'identity_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['code', 'name', 'is_active'], 'required'],
            [['is_active', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 128],
            [['code'], 'string', 'max' => 7],
            [['code'], 'unique']
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
            'is_active' => 'Is Active',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }

    public static function getUniqueCode() {
        /*
         * This function is called to generate a unique number for each vehicle being registered
         * 
         * At the end the code will look as, GP_00001
         */
        $lastType = self::find()
                ->orderBy(['code' => SORT_DESC])
                ->select('code')
                ->one();
        if ($lastType === null) {
            return 'TYPE_01';
        }
        $code = $lastType->code;
        $count = (int) explode("_", $code)[1];
        $newCount = $count + 1;
        $missingDigits = self::NUMBERS_COUNT_IN_CODE - strlen($newCount . '');
        $prefix = '';
        for ($index = 1; $index <= $missingDigits; $index++) {
            $prefix .= '0';
        }
        return 'TYPE_' . $prefix . '' . $newCount;
    }

    public static function getTypes() {
        $models = self::find()
                ->where(['is_active' => DataDefinition::BOOLEAN_TYPE_YES])
                ->all();
        return ArrayHelper::map($models, 'id', 'name');
    }

}
