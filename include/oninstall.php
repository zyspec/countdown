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
 * @copyright Copyright (c) 2001-2020 {@link https://xoops.org XOOPS Project}
 * @author    XOOPS Module Development Team
 * @link      https://github.com/XoopsModules25x/xforms
 * @since     0.30
 */

use XoopsModules\Countdown;
use XoopsModules\Countdown\Helper;
use XoopsModules\Countdown\Utility;

require_once dirname(__DIR__) . '/preloads/autoloader.php';

/**
 * {@internal {Make sure you PROTECT THIS FILE }}
 */
if ((!defined('XOOPS_ROOT_PATH'))
   || !$GLOBALS['xoopsUser'] instanceof \XoopsUser
   || !$GLOBALS['xoopsUser']->isAdmin())
{
     exit('Restricted access' . PHP_EOL);
}

 /**
 * Prepares system prior to attempting to install module
 *
 * @param \XoopsModule $module {@link XoopsModule}
 * @return bool true if ready to install, false if not
*/
function xoops_module_pre_install_countdown(\XoopsModule $module)
{
    /** @var \XoopsModules\Countdown\Utility $utility */
    $utility      = new Utility();
    $xoopsSuccess = $utility::checkVerXoops($module);
    $phpSuccess   = $utility::checkVerPHP($module);

    return $xoopsSuccess && $phpSuccess;
}

/**
 * Performs tasks required during installation of the module
 *
 * @param \XoopsModule $module {@link XoopsModule}
 * @return bool true if installation successful, false if not
 */
function xoops_module_install_countdown(\XoopsModule $module)
{
    $success = true;

    return $success;
}
