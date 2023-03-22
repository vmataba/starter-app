<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
use app\assets\DataDefinition;
use yii\helpers\Html;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username
 * @property string $password
 * @property string $auth_key
 * @property string $access_token
 * @property int $salutation
 * @property string $first_name
 * @property string $middle_name
 * @property string $surname
 * @property string $phone
 * @property string $email
 * @property string $photo
 * @property int $default_system_route_id
 * @property int $has_default_password
 * @property int $is_active
 * @property string $last_login
 * @property int $created_at
 * @property int $created_by
 * @property int $updated_at
 * @property int $updated_by
 */
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface {

    const DEFAULT_USER_PHOTO = 'uploads/user-photo/default.jpeg';
    const DEFAULT_PASSWORD = '12345';

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['username', 'auth_key', 'access_token', 'salutation', 'first_name', 'surname', 'phone', 'email'], 'required'],
            [['salutation', 'is_active', 'created_by', 'updated_by', 'default_system_route_id'], 'integer'],
            [['last_login', 'has_default_password', 'created_at', 'updated_at'], 'safe'],
            [['username', 'auth_key', 'access_token', 'first_name', 'middle_name', 'surname', 'email'], 'string', 'max' => 128],
            [['password'], 'string', 'max' => 256],
            [['phone'], 'string', 'max' => 16],
            [['photo'], 'string', 'max' => 512],
            [['username'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'password' => 'Password',
            'auth_key' => 'Auth Key',
            'access_token' => 'Access Token',
            'salutation' => 'Salutation',
            'first_name' => 'First Name',
            'middle_name' => 'Middle Name',
            'surname' => 'Surname',
            'phone' => 'Phone',
            'email' => 'Email',
            'photo' => 'Photo',
            'default_system_route_id' => 'Default Url',
            'is_active' => 'Is Active',
            'last_login' => 'Last Login',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }

    public function getAuthKey() {
        return $this->auth_key;
    }

    public function getId() {
        return $this->id;
    }

    public function validateAuthKey($authKey) {
        return $authKey === $this->auth_key;
    }

    public static function findIdentity($id) {
        return self::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null) {
        return self::findOne(['access_token' => $token]);
    }

    public static function findByUsername($username) {
        return self::findOne(['username' => $username]);
    }

    public function validatePassword($password) {
        return \Yii::$app->getSecurity()->validatePassword($password, $this->password);
    }

    public function getPhoto() {
        return $this->photo;
    }

    public function getFullName() {
        return $this->getSalutation()->name . ". {$this->first_name} {$this->surname}";
    }

    public function getSalutation() {
        return Salutation::findOne($this->salutation);
    }

    public static function count() {
        return self::find()->count();
    }

    public function countGroups() {
        return GroupMember::find()->where(['user_id' => $this->id, 'is_active' => DataDefinition::BOOLEAN_TYPE_YES])->count();
    }

    public function hasGroups() {
        return $this->countGroups() > 0;
    }

    public function getGroups() {
        $models = GroupMember::find()
                ->where(['user_id' => $this->id])
                ->andWhere("`group_id` IN (SELECT `id` FROM `user_group` WHERE `is_active` = 1)")
                ->andWhere(['is_active' => DataDefinition::BOOLEAN_TYPE_YES])
                ->all();
        return $models;
    }

    public function getFreeGroups() {
        $models = UserGroup::find()
                ->where("id NOT IN (SELECT group_id FROM is_member WHERE user_id = $this->id)")
                ->all();
        return ArrayHelper::map($models, "id", "name");
    }

    public function canPerform($route) {

        $params = explode("/", $route);

        if (sizeof($params) < 3) {
            $controller = $params[0];
            $action = $params[1];


            $systemRoute = SystemRoute::findOne([
                        'controller' => $controller,
                        'action' => $action,
                        'is_active' => DataDefinition::BOOLEAN_TYPE_YES
            ]);

            if ($systemRoute === null) {
                return false;
            }

            foreach ($this->getGroups() as $group) {
                $canPerform = CanPerform::findOne([
                            'group_id' => $group->getGroup()->id,
                            'system_route_id' => $systemRoute->id,
                            'is_active' => DataDefinition::BOOLEAN_TYPE_YES
                ]);
                if ($canPerform === null) {
                    continue;
                } else {
                    return true;
                }
            }
            return false;
        }
        $module = $params[0];
        $controller = $params[1];
        $action = $params[2];

        $systemRoute = SystemRoute::findOne([
                    'module' => $module,
                    'controller' => trim($controller),
                    'action' => trim($action),
                    'is_active' => DataDefinition::BOOLEAN_TYPE_YES
        ]);

        if ($systemRoute === null) {
            return false;
        }

        foreach ($this->getGroups() as $group) {
            $canPerform = CanPerform::findOne([
                        'group_id' => $group->getGroup()->id,
                        'system_route_id' => $systemRoute->id,
                        'is_active' => DataDefinition::BOOLEAN_TYPE_YES
            ]);
            if ($canPerform === null) {
                continue;
            } else {
                return true;
            }
        }
        return false;
    }

    public function canView($route) {
        return $this->canPerform($route);
    }

    public function canViewAny($routes = []) {
        if (empty($routes)) {
            return false;
        }
        $feedback = false;
        foreach ($routes as $key => $route) {
            $feedback = $feedback || $this->canView($route);
        }
        return $feedback;
    }

    public function isAdmin() {
        return true;
    }

    public function getNamedGroups() {
        $names = [];
        foreach ($this->getGroups() as $membership) {
            array_push($names, Html::a($membership->getGroup()->name, ['/user-group/view', 'id' => $membership->group_id], ['target' => 'blank']));
        }
        if (count($names) < 1) {
            return "(not assigned)";
        }
        return implode(",", $names);
    }

    public function getDisplayGroups() {
        $label = "";
        $count = 0;
        $groupsCount = $this->countGroups();
        foreach ($this->getGroups() as $membership) {
            $count++;
            $label .= $membership->getGroup()->name;

            if ($count < $groupsCount) {
                $label .= " | ";
            }
        }
        return $label;
    }

    public function countLogins() {
        return Login::find()->where(['user_id' => $this->id])->count();
    }

    public function hasDefaultPage() {
        return !empty($this->default_system_route_id);
    }

    public function getDefaultSystemRoute() {
        return SystemRoute::findOne($this->default_system_route_id);
    }

    public function hasDefaultPassword() {
        return $this->has_default_password !== null && (int) $this->has_default_password === DataDefinition::BOOLEAN_TYPE_YES;
    }

    public function isActive() {
        return $this->is_active !== null && (int) $this->is_active === DataDefinition::BOOLEAN_TYPE_YES;
    }

}
