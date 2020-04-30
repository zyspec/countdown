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

    use Common\FilesManagement; // Files Management Trait


    /** @var array errs list of errors */
    public static $errs = [];

    /**
     * Create folder & index.html file
     *
     * @param string $folder The full path of the directory to create
     * @return bool
     */
    public static function createFolder($folder)
    {
        $success = true;
        try {
            if (!file_exists($folder)) {
                if (!is_dir($folder) && !mkdir($folder) && !is_dir($folder)) {
                    $errMsg = sprintf('Unable to create the %s directory', $folder);
                    throw new \RuntimeException($errMsg);
                    self::setErrors($errMsg, false);
                    $success = false;
                }
                if (false === file_put_contents($folder . '/index.html', '<script>history.go(-1);</script>')) {
                    $errMsg = "Unable to create {$folder}/index.html";
                    self::setErrors($errMsg, false);
                    $success = false;
                }
            }
        } catch (\Exception $e) {
            $errMsg = sprintf("Caught exception: %s", $e->getMessage());
            $success = false;
            sself::setErrors($errMsg, false);
            echo $errMsg;
        } finally {
            return $success;
        }
    }

    /**
     * @param $file
     * @param $folder
     * @return bool
     */
    public static function copyFile($file, $folder)
    {
        return copy($file, $folder);
        //        try {
        //            if (!is_dir($folder)) {
        //                throw new \RuntimeException(sprintf('Unable to copy file as: %s ', $folder));
        //            } else {
        //                return copy($file, $folder);
        //            }
        //        } catch (\Exception $e) {
        //            echo 'Caught exception: ', $e->getMessage(), "\n", "<br>";
        //        }
        //        return false;
    }

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
    /**
     * @param  array $errors
     * @return string
     */
    public static function getHtmlErrors($errors = [])
    {
        $ret = '';
        foreach ($errors as $key => $value) {
            $ret .= '\n<br> - ' . $value;
        }

        return $ret;
    }

}
