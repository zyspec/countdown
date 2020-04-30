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
 * Module: Xforms
 *
 * @package   \XoopsModules\Countdown
 * @license   https://www.gnu.org/licenses/gpl-2.0.html GNU Public License
 * @copyright Copyright (c) 2001-2020 {@link https://xoops.org XOOPS Project}
 * @author    XOOPS Module Development Team
 * @author    Mamba <mambax7@gmail.com>
 * @author    ZySpec <zyspec@yahoo.com>
 * @link      https://github.com/XoopsModules25x/countdown
 * @since     0.30
 */

use XoopsModules\Countdown;
use XoopsModules\Countdown\Common;

 /**
  * \XoopsModules\Xforms\Utility
  *
  * Static utility class to provide common functionality
  *
  */
class Utility
{
    use Common\VersionChecks; //checkVerXoops, checkVerPhp Traits

    /** @var array errs list of errors */
    public static $errs = [];

    /**
     * Set errors for the Utility class
     *
     * @param string|array item
     * @param bool replace true to replace errors, false to add item to list of errors
     *
     * @return int
     */
    public static function setErrors($item, $replace = true) {
        if (!empty($item)) {
            $item = (array)$item;
            if ($replace) {
                static::$errs = $item;
            } else {
                static::$errs = array_merge(static::$errs, $item);
                static::$errs = array_unique(static::$errs);
            }
        } else {
            static::$errs = []; // clears the array if $item is empty
        }
        return static::errs;
    }

    /**
     * Get Utility class errors
     *
     * @return array
     */
    public static function getErrors() {

        return static::$errs;
    }
}
