<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models;

/**
 * Description of Person
 *
 * @author Victor Mataba <vmataba0@gmail.com>
 */
class Person {

    const GENDER_MALE = 'M';
    const GENDER_FEMALE = 'F';
    const DEFAULT_PHOTO = 'uploads/default/default_photo.png';
    const DEFAULT_MALE_PHOTO = 'uploads/default/default_male_photo.png';
    const DEFAULT_FEMALE_PHOTO = 'uploads/default/default_female_photo.png';

    public static function getGenders() {
        return [
            self::GENDER_MALE => self::GENDER_MALE,
            self::GENDER_FEMALE => self::GENDER_FEMALE
        ];
    }

}
