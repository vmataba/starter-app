<?php

namespace app\models;

use app\assets\DataDefinition;
use yii\db\Query;

/**
 * This is the model class for table "user_group".
 *
 * @property int $id
 * @property string $code
 * @property string $name
 * @property string $description
 * @property int $is_active
 * @property string $created_at
 * @property int $created_by
 * @property string $updated_at
 * @property int $updated_by
 *
 */
class UserGroup extends \yii\db\ActiveRecord {

    const NUMBERS_COUNT_IN_CODE = 4;
    const SUPER_AMIN_GROUP_CODE = 'GP_0001';
    const EMPLOYEE_GROUP_CODE = 'GP_0003';

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'user_group';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['code', 'name', 'created_by'], 'required'],
            [['is_active', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['code'], 'string', 'max' => 128],
            [['name'], 'string', 'max' => 50],
            [['description'], 'string', 'max' => 512],
            [['code'], 'unique'],
            [['name'], 'unique']
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
        $lastGroup = self::find()
            ->orderBy(['code' => SORT_DESC])
            ->select('code')
            ->one();
        if (!$lastGroup) {
            return 'GP_0001';
        }
        $count = (int)explode("_", $lastGroup['code'])[1];
        $newCount = $count + 1;
        $missingDigits = self::NUMBERS_COUNT_IN_CODE - strlen($newCount . '');
        $prefix = '';
        for ($index = 1; $index <= $missingDigits; $index++) {
            $prefix .= '0';
        }
        return 'GP_' . $prefix . $newCount;
    }

    public function countRoutes() {
        return (new Query())
            ->select('can_perform.id')
            ->from(['can_perform' => CanPerform::tableName()])
            ->where([
                'can_perform.group_id' => $this->id,
                'can_perform.is_active' => DataDefinition::BOOLEAN_TYPE_YES])
            ->count();
    }

    public function hasRoutes(): bool {
        return $this->countRoutes() > 0;
    }

    public function hasMembers() {
        $models = GroupMember::find()
            ->where(['group_id' => $this->id])
            ->andWhere(['is_active' => DataDefinition::BOOLEAN_TYPE_YES]);
        return $models->count() > 0;
    }

    public function getMembers() {
        $models = GroupMember::find()
            ->where(['group_id' => $this->id])
            ->andWhere(['is_active' => DataDefinition::BOOLEAN_TYPE_YES])
            ->all();
        return $models;
    }

    public function getRoutes() {
        $models = CanPerform::find()
            ->where(['group_id' => $this->id])
            ->andWhere(['is_active' => DataDefinition::BOOLEAN_TYPE_YES])
            ->all();
        return $models;
    }

    public function getFreeRoutes() {
        $models = SystemRoute::find()
            ->where("id NOT IN (SELECT system_route_id FROM can_perform WHERE group_id = $this->id AND is_active = 1)")
            ->andWhere(['is_active' => DataDefinition::BOOLEAN_TYPE_YES])
            ->orderBy(['controller' => SORT_ASC])
            ->all();
        $routes = [];
        foreach ($models as $model) {
            $routes[$model->id] = $model->pretty_name;
        }
        return $routes;
    }

    public function getFreeUsers() {
        $models = User::find()
            ->where("id NOT IN (SELECT user_id FROM is_member WHERE group_id = $this->id)")
            ->andWhere(['is_active' => DataDefinition::BOOLEAN_TYPE_YES])
            ->all();
        $users = [];
        foreach ($models as $model) {
            $users[$model->id] = $model->getFullName();
        }
        return $users;
    }

    public function hasMember($userid) {
        $model = GroupMember::findOne([
            'group_id' => $this->id,
            'user_id' => $userid,
            'is_active' => DataDefinition::BOOLEAN_TYPE_YES
        ]);
        return $model !== null;
    }

    public function addMember($userId) {
        $user = User::findOne($userId);
        if ($user === null) {
            return;
        }
        $groupMember = new GroupMember();
        $groupMember->user_id = $user->id;
        $groupMember->group_id = $this->id;
        $groupMember->created_at = date('Y-m-d H:i:s');
        $groupMember->created_by = \Yii::$app->user->id;
        return $groupMember->save();
    }

    public function countMembers() {
        return (int)GroupMember::find()->where(['group_id' => $this->id])
            ->andWhere(['is_active' => DataDefinition::BOOLEAN_TYPE_YES])
            ->count();
    }

    public function canBeDeleted() {
        if ($this->code === self::SUPER_AMIN_GROUP_CODE || $this->code === self::EMPLOYEE_GROUP_CODE) {
            return false;
        }
        if ($this->countMembers() > 0) {
            return false;
        }
        return true;
    }

}
