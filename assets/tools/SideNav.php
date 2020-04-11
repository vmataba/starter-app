<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\assets\tools;

/**
 * Description of SideNav
 *
 * @author Victor Mataba <vmataba0@gmail.com>
 */
use yii\helpers\Url;

class SideNav {
    /* Starts list item */

    public static function startMenuItem($showMenuItem = true) {
        if (!$showMenuItem) {
            echo "<li style='display:none'>";
        } else {
            echo "<li>";
        }
    }

    /*
     * config properties are:
     *  1. optional module
     *  2. required controller
     *  3. required action
     *  4. optional icon
     *  5. required label
     *  6. optional params
     */

    public static function createMenuItem($config = []) {
        if (empty($config) || !isset($config)) {
            return "";
        }
        $url = "/";
        if (isset($config['module'])) {
            $url .= $config['module'] . "/";
        }
        $url .= $config['controller'] . "/";
        $url .= $config['action'];

        $a = "<a href=";

        if (isset($config['params'])) {
            $a .= Url::to(array_merge([$url], $config['params']));
        } else {
            $a .= Url::to([$url]);
        }

        $a .= ">";
        if (isset($config['icon'])) {
            $a .= "<i class='" . $config['icon'] . "'></i>";
        }

        $a .= "<span>" . $config['label'] . "</span>";
        $a .= "</a>";
        return $a;
    }

    /* Ends list item */

    public static function endMenuItem() {
        echo "</li>";
    }

    public static function startMenuItemsGroup($config = []) {
        if (empty($config) || !isset($config) || empty($config['groupId']) || empty($config['label'])) {
            echo "";
            return;
        }
        $feedback = "";


        if (!isset($config['visible']) || !$config['visible']) {
            $feedback .= "<li style='display:none'>";
        } else {
            $feedback = "<li>";
        }

        $feedback .= "<a href='#" . $config['groupId'] . "' ";
        $feedback .= "data-toggle='collapse'";
        $feedback .= "class='collapsed'>";
        if (isset($config['icon'])) {
            $feedback .= "<i class='" . $config['icon'] . "'></i> ";
        }
        $feedback .= "<span>" . $config['label'] . "</span>";
        $feedback .= "<i class='icon-submenu lnr lnr-chevron-left'></i>";
        $feedback .= "</a>";
        $feedback .= "</li>";
        $feedback .= "<div id='" . $config['groupId'] . "' class='collapse'>";
        $feedback .= "<ul class='nav'>";

        echo $feedback;
    }

    public static function endMenuItemsGroup() {
        echo "</ul>
            </div>
        </li>";
    }

}
