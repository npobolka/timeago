<?php

class Timeago {
    public static $language;

    /**
     * Declension of word
     *
     * @access private
     * @param integer $count
     * @param string|array $forms
     * @return string
     */
    private static function decliner($count, $forms) {
        if (!is_array($forms)) {
            $forms = explode(';',$forms);
        }
        $count = abs($count);
        if (is_null(static::$language)) {
            static::$language = Config::get('application.language');
        }

        if (static::$language !== Config::get('application.language')) { }

        if (static::$language === 'ru') {
            $mod100 = $count % 100;
            switch ($count % 10) {
                case 1:
                    if ($mod100 == 11) return $forms[2];
                    else return $forms[0];
                case 2:
                case 3:
                case 4:
                    if (($mod100 > 10) && ($mod100 < 20)) return $forms[2];
                    else return $forms[1];
                case 5:
                case 6:
                case 7:
                case 8:
                case 9:
                case 0: return $forms[2];
            }
        }
        else {
            /**
             * If lang not RU
             */
            return ($count == 1) ? $forms[0] : $forms[1];
        }
    }

    /**
     * Funny date
     *
     * @access public
     * @param integer $time UNIX timestamp
     * @return string
     */
    public static function funny($time) {
        $seconds = abs(time() - $time);
        $minutes = floor($seconds / 60);
        $hours = floor($minutes / 60);
        $days = floor($hours / 24);
        $months = floor($days / 30);
        $years = floor($days / 365);
        $seconds = floor($seconds);

        if ($seconds < 15) {
            return __('timeago::time.now');
        }
        if ($seconds < 45) {
            return static::decliner($seconds, __('timeago::time.seconds_back', array('seconds' => $seconds)));
        }
        if ($seconds < 60) {
            return __('timeago::time.minutes_back_less');
        }
        if ($minutes < 45) {
            return static::decliner($minutes, __('timeago::time.minutes_back', array('minutes' => $minutes)));
        }
        if ($minutes < 60) {
            return  __('timeago::time.hours_back_less');
        }
        if ($hours < 24) {
            return static::decliner($hours, __('timeago::time.hours_back', array('hours' => $hours)));
        }
        if ($days < 30) {
            return static::decliner($days, __('timeago::time.days_back', array('days' => $days)));
        }
        if ($days < 365) {
            return static::decliner($months, __('timeago::time.month_back', array('months' => $months)));
        }
        if ($days > 365) {
            return static::decliner($years, __('timeago::time.years_back', array('years' => $years)));
        }
        return date('j-m-Y, G:i', $time);
    }

}