<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models\validators;

use yii\base\Model;

/**
 * Description of NewPassword
 *
 * @author Victor Mataba <vmataba0@gmail.com>
 */
class NewPassword extends Model {

    public $newPassword;
    public $confirmationPassword;

    public function rules() {
        return [
            [['newPassword', 'confirmationPassword'], 'required'],
            [['confirmationPassword'], 'compare', 'compareAttribute' => 'newPassword', 'operator' => '==']
        ];
    }

    public function attributeLabels() {
        return [
            'newPassword' => 'Password',
            'confirmationPassword' => 'Confirm Password'
        ];
    }

}
