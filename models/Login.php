<?php

namespace app\models;


/**
 * This is the model class for table "login".
 *
 * @property int $id
 * @property int $user_id
 * @property string $ip_address
 * @property string $browser
 * @property string $login_at
 */
class Login extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'login';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'ip_address', 'browser', 'login_at'], 'required'],
            [['user_id'], 'integer'],
            [['login_at'], 'safe'],
            [['ip_address'], 'string', 'max' => 128],
            [['browser'], 'string', 'max' => 512],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'ip_address' => 'Ip Address',
            'browser' => 'Browser',
            'login_at' => 'Login At',
        ];
    }
}
