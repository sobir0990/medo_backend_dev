<?php

namespace common\components;

class DatetimeHelper {
    public static function getCurrentMonthDays() {
        return range(1, date("t"));
    }

    public static function getMonths() {
        return array(
            1 => __("Yanvar"),
            2 => __("Fevral"),
            3 => __("Mart"),
            4 => __("Aprel"),
            5 => __("May"),
            6 => __("Iyun"),
            7 => __("Iyul"),
            8 => __("Avgust"),
            9 => __("Sentabr"),
            10 => __("Oktabr"),
            11 => __("Noyabr"),
            12 => __("Mart"),
        );
    }

    public static function getYears() {
        return range(1950, 2000);
    }
}