<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\assets;

/**
 * Description of DataDefinition
 *
 * @author Victor Mataba <vmataba0@gmail.com>
 */
class DataDefinition {

    const BOOLEAN_STATUS_ACTIVE = 1;
    const BOOLEAN_STATTUS_INACTIVE = 0;
    const BOOLEAN_TYPE_YES = 1;
    const BOOLEAN_TYPE_NO = 0;
    
    const MAX_PERCENT_VALUE = 100;

    public static function getBooleanStatuses() {
        return [
            self::BOOLEAN_STATUS_ACTIVE => 'Active',
            self::BOOLEAN_STATTUS_INACTIVE => 'Inactive'
        ];
    }

    public static function getBooleanTypes() {
        return [
            self::BOOLEAN_TYPE_YES => 'Yes',
            self::BOOLEAN_TYPE_NO => 'No'
        ];
    }

    public static function getStyledBooleanTypes() {
        return [
            self::BOOLEAN_TYPE_YES => '<span class="label label-success" style="border-radius: 11px">Yes</span>',
            self::BOOLEAN_TYPE_NO => '<span class="label label-danger" style="border-radius: 11px">No</span>'
        ];
    }

    
}
