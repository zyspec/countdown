<?php
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
 * @copyright Copyright (c) 2001-2020 {@link http://xoops.org XOOPS Project}
 * @author    XOOPS Module Development Team
 * @link      https://github.com/XoopsModules25x/countdown
 * @since     0.30
 */

/**
 * @internal {Make sure you PROTECT THIS FILE}
 */
use XoopsModules\Countdown;
use XoopsModules\Countdown\Helper;
use XoopsModules\Countdown\Utility;

if ((!defined('XOOPS_ROOT_PATH'))
    || !($GLOBALS['xoopsUser'] instanceof \XoopsUser)
    || !($GLOBALS['xoopsUser']->isAdmin()))
{
    exit('Restricted access' . PHP_EOL);
}

/**
 * Prepare to uninstall module
 *
 * @param XoopsModule $module
 *
 * @return bool success
 */
function xoops_module_pre_uninstall_countdown(\XoopsModule $module)
{
    $success = true;
    // NOP
    return $success;
}

/**
 * Uninstall module
 *
 * @param XoopsModule $module
 *
 * @return bool success
 */
function xoops_module_uninstall_countdown(\XoopsModule $module)
{
    $success = true;
    //NOP
    return $success;
}
