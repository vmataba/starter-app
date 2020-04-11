<?php

namespace app\models;


/**
 * This is the model class for table "can_perform".
 *
 * @property int $id
 * @property int $group_id
 * @property int $system_route_id
 * @property string $created_at
 * @property int $created_by
 * @property string $updated_at
 * @property int $updated_by
 * @property int $is_active
 */
class CanPerform extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'can_perform';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['group_id', 'system_route_id'], 'required'],
            [['group_id', 'system_route_id', 'created_by', 'updated_by', 'is_active'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'group_id' => 'Group',
            'system_route_id' => 'System Route',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'is_active' => 'Is Active',
        ];
    }

    public function getGroup() {
        $model = UserGroup::findOne($this->group_id);
        return $model;
    }

    public function getRoute() {
        $model = SystemRoute::findOne($this->system_route_id);
        return $model;
    }

}
