<?php

namespace app\models\validators;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\base\Model;

/**
 * Description of RecoveryPassword
 *
 * @author Victor Mataba <vmataba0@gmail.com>
 */
class RecoveryPassword extends Model {

    public $password;

    public function rules() {
        return [
            [['password'], 'required']
        ];
    }

    public function attributeLabels() {
        return [
            'password' => 'Recovery Password'
        ];
    }

}
