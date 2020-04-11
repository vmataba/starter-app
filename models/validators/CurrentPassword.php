<?php

namespace app\models\validators;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RecoveryPassword
 *
 * @author Victor Mataba <vmataba0@gmail.com>
 */
class CurrentPassword extends RecoveryPassword {

    public function attributeLabels() {
        return [
            'password' => 'Current Password'
        ];
    }

}
