<?php

namespace app\assets\tools;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Tool
 *
 * @author Victor Mataba <vmataba0@gmail.com>
 */

use Yii;

class Tool {

    const DAYS_IN_A_MONTH = 30.4167;
    const SALARY_DAYS_COUNT_INTERVAL = 24;

    public static function getNoContentMessage() {
        return "<i class='glyphicon glyphicon-trash'></i> No content";
    }

    public static function getFormattedDate($date, $includeTime = true) {

        $splittedDate = explode(' ', $date);
        $onlyDate = $splittedDate[0];
        $onlyTime = null;
        $splittedOnlyDate = explode('-', $onlyDate);

        $year = $splittedOnlyDate[0];
        $month = $splittedOnlyDate[1];
        $day = $splittedOnlyDate[2];

        if ($includeTime) {
            $onlyTime = $splittedDate[1];
        }

        switch ((int)$month) {
            case 1:
                $textMonth = 'Jan';
                break;
            case 2:
                $textMonth = 'Feb';
                break;
            case 3:
                $textMonth = 'Mar';
                break;
            case 4:
                $textMonth = 'April';
                break;
            case 5:
                $textMonth = 'May';
                break;
            case 6:
                $textMonth = 'Jun';
                break;
            case 7:
                $textMonth = 'Jul';
                break;
            case 8:
                $textMonth = 'Aug';
                break;
            case 9:
                $textMonth = 'Sept';
                break;
            case 10:
                $textMonth = 'Oct';
                break;
            case 11:
                $textMonth = 'Nov';
                break;
            case 12:
                $textMonth = 'Dec';
                break;
        }


        return $includeTime ? "{$textMonth}, {$day} {$year} {$onlyTime}" : "{$textMonth}, {$day} {$year}";
    }

    public static function span($date1, $date2, $format = null) {
        if ($format == null) {
            $format = "a"; //will return the number of days
        }
        $output = 0;
        if (!empty($date1) && !empty($date2)) {
            $d1 = date_create($date1);
            $d2 = date_create($date2);
            $difference = $d1->diff($d2);

            $output = $difference->format("%" . $format);
        }

        return $output;
    }

    public static function getElapsedTime($date, $includeTime = true) {
        $output = '';
        $past = ['ago', 'pasted', 'previous', '', '', ''];
        $future = ['to come', 'remained', 'next', '', '', ''];
        $period = [];
        $today = date('Y-m-d H:i:s');

        if (strtotime($date) < strtotime($today)) { //Has Already Happened
            $period = $past;
        } else { //Has Not yet Happened
            $period = $future;
        }

        $minutes = $hours = $days = $months = $years = 0;
        $minutes = self::span($date, $today, 'i');
        $hours = self::span($date, $today, 'h');
        $days = self::span($date, $today, 'a');
        $months = self::span($date, $today, 'm');
        $years = self::span($date, $today, 'y');
        if ($years) {
            $output = number_format($years, 0);
            $years > 1 ? $output .= ' years ' : $output .= ' year ';
            $output .= $period[0];
        }
        if ($months && !$years) {
            $output = number_format($months, 0);
            $months > 1 ? $output .= ' months ' : $output .= ' month ';
            $output .= $period[0];
        }
        if ($days && !$months) {
            $output = number_format($days, 0);
            $days > 1 ? $output .= ' days ' : $output .= ' day ';
            $output .= $period[0];
        }
        if ($hours && !$days) {
            $output = number_format($hours, 0);
            $hours > 1 ? $output .= ' hours ' : $output .= ' hour ';
            $output .= $period[0];
        }
        if ($minutes && !$hours) {
            $output = number_format($minutes, 0);
            $minutes > 1 ? $output .= ' minutes ' : $output .= ' minute ';
            $output .= $period[0];
        }
        if (!$minutes && !$hours && !$days && !$months && !$years) {
            $output = 'few seconds ago';
        }


        return $output;
    }

    public static function getClientIpAddress() {
        return getenv('HTTP_CLIENT_IP') ? getenv('HTTP_X_FORWARDED_FOR') : getenv('REMOTE_ADDR');
    }

    public static function getBrowserInfo() {
        return $_SERVER['HTTP_USER_AGENT'];
    }

    public static function getBaseUrl() {
        return $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/' . explode('/', $_SERVER['REQUEST_URI'])[1];
    }

    public static function sortByValue($array) {
        $alphabets = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'LM'];
        $newArray = [];
        foreach ($alphabets as $alphabet) {
            foreach ($array as $key => $val) {
                if (substr($val, 0, 1) == $alphabet) {
                    $newArray[$key] = $val;
                }
            }
        }
        return $newArray;
    }

    public static function countDays($date1, $date2) {
        if (\DateTime::createFromFormat("Y-m-d", $date1) === false || \DateTime::createFromFormat("Y-m-d", $date2) === false) {
            return 0;
        }
        $newDate1 = date_create($date1);
        $newDate2 = date_create($date2);
        $difference = (int)date_diff($newDate1, $newDate2)->format("%R%a");
        return $difference < 0 ? $difference * -1 : $difference;
    }

    public static function countMonths($date1, $date2) {
        return round((double)number_format(self::countDays($date1, $date2) / self::DAYS_IN_A_MONTH, 2));
    }

    public static function getMonths() {
        return [
            1 => 'January',
            2 => 'February',
            3 => 'March',
            4 => 'April',
            5 => 'May',
            6 => 'June',
            7 => 'July',
            8 => 'Augost',
            9 => 'September',
            10 => 'October',
            11 => 'November',
            12 => 'December'
        ];
    }

    public static function getYears($maxYear = 2050) {
        $rawYears = range($maxYear, 2005);
        $years = [];
        foreach ($rawYears as $index => $year) {
            $years[$year] = $year;
        }
        return $years;
    }

    public static function serializeModelErrors($errors) {
        $errorMessage = '';
        foreach ($errors as $attributeError) {
            $errorMessage .= $attributeError[0];
        }
        return str_replace(".", ",", rtrim($errorMessage, "."));
    }

    public static function getNextDate($year, $month, $monthsCount, $reduce = true) {
        if (!is_numeric($year) || !is_numeric($month) || !is_numeric($month)) {
            return [
                'month' => $month,
                'year' => $year
            ];
        }

        if ($reduce) {
            $monthsCount--;
        }

        $newMonth = ($month + $monthsCount) % 12;
        $yearIncrement = (int)(($month + $monthsCount) / 12);
        $newYear = $year + $yearIncrement;

        $computedMonth = $newMonth;

        if ((int)$computedMonth === 0) {
            $computedMonth = 12;
            $newYear = $year + ($yearIncrement - 1);
        } else {
            if ($computedMonth < 0) {
                $computedMonth = 1;
            }
        }

        return [
            'month' => $computedMonth,
            'year' => $reduce && (int)$monthsCount === 1 ? $year : $newYear
        ];
    }

    public static function showLoader() {
        return "<center><img src='icons/loader.gif' class='loader' style='height: 120px; width: 120px'></img></center>";
    }

    public static function getMinLoader($width = 10, $height = 10) {
        return "<img src='icons/loader.gif' class='loader' style='height: {$height}px; width: {$width}px'></img>";
    }

    public static function countDaysInMonth($month = null, $year = null) {
        if ($month === null) {
            $month = (int)date('m');
        }
        if ($year === null) {
            $year = (int)date('Y');
        }
        return cal_days_in_month(CAL_GREGORIAN, (int)$month, (int)$year);
    }

    public static function getFullPath($file):string {
        return Yii::$app->request->baseUrl . '/' . $file;
    }

    public static function getSearchIcon() {
        return self::getFullPath('icons/search.svg');
    }

    public static function getResetIcon() {
        return self::getFullPath('icons/reset.png');
    }

    public static function getExcelIcon() {
        return self::getFullPath('icons/ms-excel.svg');
    }

    public static function getPdfIcon() {
        return self::getFullPath('icons/pdf.png');
    }

    public static function getPngIcon() {
        return self::getFullPath('icons/png.png');
    }

    public static function getKeyPassIcon() {
        return self::getFullPath('icons/key-pass.svg');
    }

}
