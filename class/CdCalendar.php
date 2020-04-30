<?php

namespace XoopsModules\Countdown;

/*
 You may not change or alter any portion of this comment or credits of
 supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit
 authors.

 This program is distributed in the hope that it will be useful, but
 WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */
/**
 * Module: Countdown
 *
 * @package   \XoopsModules\Countdown
 * @license   https://www.gnu.org/licenses/gpl-2.0.html GNU Public License
 * @copyright Copyright (c) 2001-2020 {@link https://xoops.org XOOPS Project}
 * @author    XOOPS Module Development Team
 * @link      https://github.com/XoopsModules25x/countdown
 * @since     0.30
 */

use XoopsModules\Countdown\Constants;

/**
 * Time/Calendar manipulation functions class
 */
class CdCalendar
{
    /**
     * Format the time into human readable text
     *
     * This function is code borrowed from xhelp.
     *
     * @param int $time
     * @return string
     */
    public static function formatTime($time)
    {
        $values = self::getElapsedTime($time);

        foreach ($values as $key => $value) {
            $$key = $value;
        }

        $ret = [];
        if ($values['years']) {
            $ret[] = $values['years'] . ' ' . (1 == $values['years'] ? _COUNTDOWN_TIME_YEAR : _COUNTDOWN_TIME_YEARS);
        }

        if ($values['weeks']) {
            $ret[] = $values['weeks'] . ' ' . (1 == $values['weeks'] ? _COUNTDOWN_TIME_WEEK : _COUNTDOWN_TIME_WEEKS);
        }

        if ($values['days']) {
            $ret[] = $values['days'] . ' ' . (1 == $values['days'] ? _COUNTDOWN_TIME_DAY : _COUNTDOWN_TIME_DAYS);
        }

        if ($values['hours']) {
            $ret[] = $values['hours'] . ' ' . (1 == $values['hours'] ? _COUNTDOWN_TIME_HOUR : _COUNTDOWN_TIME_HOURS);
        }

        if ($values['minutes']) {
            $ret[] = $values['minutes'] . ' ' . (1 == $values['minutes'] ? _COUNTDOWN_TIME_MIN : _COUNTDOWN_TIME_MINS);
        }

        $ret[] = $values['seconds'] . ' ' . (1 == $values['seconds'] ? _COUNTDOWN_TIME_SEC : _COUNTDOWN_TIME_SECS);

        if (($values['years'] < 0)
            || ($values['weeks'] < 0)
            || ($values['days'] < 0)
            || ($values['hours'] < 0)
            || ($values['minutes'] < 0)
            || ($values['seconds'] < 0))
        {
            return _COUNTDOWN_MSG_EXPIRED;
        } else {
            return implode(', ', $ret);
        }
    }

    /**
     * Change unix timestamp into time array
     *
     * @param int $time
     * @return array
     */
    public static function getElapsedTime($time)
    {
        $tempTz = userTimeToServerTime(0, $GLOBALS['xoopsUser']->timezone());
        $dtzObj  = new \DateTimeZone((string)($GLOBALS['xoopsUser']->timezone() * 100));
        $current = new \DateTime();
        $current->setTimeZone($dtzObj);
        $current->setTimestamp(userTimeToServerTime(time(), $GLOBALS['xoopsUser']->timezone()));
        $ending  = new \DateTime();
        $ending->setTimeZone($dtzObj);
        $ending->setTimestamp($time);
        $diff = $ending->diff($current);

        return [
            'years'   => $diff->y,
            'weeks'   => floor($diff->d / 7),
            'days'    => $diff->d % 7,
            'hours'   => $diff->h,
            'minutes' => $diff->i,
            'seconds' => $diff->s
        ];

        //Define the units of measure
        $units = [
            'years'   => 365 * 60 * 60 * 24 /*Value of Unit expressed in seconds*/,
            'weeks'   => 7 * 60 * 60 * 24,
            'days'    => 60 * 60 * 24,
            'hours'   => 60 * 60,
            'minutes' => 60,
            'seconds' => 1
        ];

        $local_time   = $time;
        $elapsed_time = [];

        //Calculate the total for each unit measure
        foreach ($units as $key => $single_unit) {
            $elapsed_time[$key] = floor($local_time / $single_unit);
            $local_time         -= ($elapsed_time[$key] * $single_unit);
        }

        return $elapsed_time;
    }
    /**
     * Create HTML select for Hours
     *
     * @param string $lSelect
     * @return string
     */
    public static function renderHourCombo($lSelect = '-1')
    {
        $sTemp    = '<select name="cboHour" id="cboHour">';

        for ($i = 1; $i <= 12; ++$i) {
            $selected = ($lSelect == $i) ? ' selected' : '';
            $sTemp .= '<option value="' . $i . '"' . $selected . '>' . sprintf("%02d", $i) . '</option>';
        }
        $sTemp .= '</select>';

        return $sTemp;
    }

    /**
     * Create HTML select for Minutes
     *
     * @param string $lSelect
     * @return string
     */
    public static function renderMinuteCombo($lSelect = '-1')
    {
        $sTemp    = '<select name="cboMinute" id="cboMinute">';
        $lSelect  = (int)$lSelect;
        $lSelect  = $lSelect - ($lSelect % 5); // sets to 5 min interval
        $lSum     = 0;

        for ($i = 0; $lSum <= 55; ++$i) {
            $selected = ($lSelect == $lSum) ? ' selected' : '';
            //if (0 == $i) {
                $sTemp .= '<option value="' . $lSum . '"' . $selected . '>' . sprintf("%02d", $lSum) . '</option>';
            //}
            $lSum    += 5;
        }
        $sTemp .= '</select>';

        return $sTemp;
    }

    /**
     * Create HTML select for AM/PM dropdown
     *
     * @param string $sSelect
     * @return string
     */
    public static function renderAMPMCombo($sSelect = 'AM')
    {
        $sTemp = '<select name="cboAMPM" id="cboAMPM">';

        if ('AM' === $sSelect) {
            $sTemp .= '<option value="' . Constants::OPTION_AM . '" selected>' . _COUNTDOWN_TIME_AM . '</option>';
            $sTemp .= '<option value="' . Constants::OPTION_PM . '">' . _COUNTDOWN_TIME_PM . '</option>';
        } else {
            $sTemp .= '<option value="' . Constants::OPTION_AM . '">' . _COUNTDOWN_TIME_AM . '</option>';
            $sTemp .= '<option value="' . Constants::OPTION_PM . '" selected>' . _COUNTDOWN_TIME_PM . '</option>';
        }

        $sTemp .= '</select>';

        return $sTemp;
    }

    /**
     * Get timestamp based on user timezone
     *
     * @param string $inpDate
     * @param array  $inpTime ['hours', 'minutes', 'seconds', 'PM']
     * @param string $format default is _SHORTDATESTRING
     *
     * @return bool|int timezone or false on failure
     */
    public static function getUserTimestamp($inpDate = null, $inpTime = null, $format = _SHORTDATESTRING)
    {
        $tz          = false;
        if ($GLOBALS['xoopsUser'] instanceof \XoopsUser) {
            $dtzObj      = new DateTimeZone((string)($GLOBALS['xoopsUser']->timezone() * 100));
            $dateTimeObj = DateTime::createFromFormat($format, $inpDate, $dtzObj);
            $bPM         = Constants::OPTION_PM == $inpTime['PM'] ? true : false;
            $hours       = array_key_exists('hours', $inpTime) ? $inpTime['hours'] % 12 : 0; // normalize time to 12 hr clock
            $hours       = $bPM ? $hours + 12 : $hours; // add 12 hrs for PM time
            $minutes     = array_key_exists('minutes', $inpTime) ? $inpTime['minutes'] : 0;
            $seconds     = array_key_exists('seconds', $inpTime) ? $inpTime['seconds'] : 0;
            $dateTimeObj->setTime($hours, $minutes, $seconds);
            $tz          = $dateTimeObj->getTimestamp();
            unset($dtzObj, $dateTimeObj); // free up memory
        }

        return $tz;

    }

    /**
     * Output the object
     *
     * @param $obj
     * @return void
     */
    public static function displayObject($obj)
    {
        echo '<pre>';
        print_r($obj);
        echo '</pre>';
    }
}