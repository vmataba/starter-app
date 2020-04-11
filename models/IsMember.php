<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "is_member".
 *
 * @property int $id
 * @property int $user_id
 * @property int $group_id
 * @property string $created_at
 * @property int $created_by
 * @property int $is_active
 * @property int $deactivated_by
 * @property string $deactivated_at
 */
class IsMember extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'is_member';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['user_id', 'group_id'], 'required'],
            [['user_id', 'group_id', 'created_by', 'is_active', 'deactivated_by'], 'integer'],
            [['created_at', 'deactivated_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'user_id' => 'User',
            'group_id' => 'Group',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'is_active' => 'Is Active',
            'deactivated_by' => 'Deactivated By',
            'deactivated_at' => 'Deactivated At',
        ];
    }

    public function getGroup() {
        $model = UserGroup::findOne($this->group_id);
        return $model;
    }

    public function getUser() {
        $model = User::findOne($this->user_id);
        return $model;
    }

}
