<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "system_route".
 *
 * @property int $id
 * @property string $module
 * @property string $controller
 * @property string $action
 * @property string $pretty_name
 * @property int $is_active
 * @property string $created_at
 * @property int $created_by
 * @property string $updated_at
 * @property int $updated_by
 */
class SystemRoute extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'system_route';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['controller', 'action', 'pretty_name', 'created_by'], 'required'],
            [['is_active', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['module', 'controller', 'action', 'pretty_name'], 'string', 'max' => 128],
            [['module', 'controller', 'action'], 'unique', 'targetAttribute' => ['module', 'controller', 'action']],
            [['pretty_name'], 'unique', 'message' => 'This name already exists']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'module' => 'Module',
            'controller' => 'Controller',
            'action' => 'Action',
            'pretty_name' => 'Pretty Name',
            'is_active' => 'Is Active',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }

    public function getRoute() {
        if (empty($this->module)) {
            return "$this->controller/$this->action";
        }
        return "$this->module/$this->controller/$this->action";
    }

    public function getCreatedBy() {
        return User::findOne($this->created_by);
    }

    public function getUpdatedBy() {
        return User::findOne($this->updated_by);
    }

    public function countUses() {
        return CanPerform::find()->where(['system_route_id' => $this->id])->count();
    }

    public function everUsed() {
        return $this->countUses() > 0;
    }

    public function canBeDeleted() {
        return !$this->everUsed();
    }

}
