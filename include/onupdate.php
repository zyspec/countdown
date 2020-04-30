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
 * Module: xForms
 *
 * @package   \XoopsModules\Xforms\include
 * @license   https://www.gnu.org/licenses/gpl-2.0.html GNU Public License
 * @copyright Copyright (c) 2001-2020 {@link https://xoops.org XOOPS Project}
 * @author    Richard Griffith <richard@geekwright.com>
 * @author    trabis <lusopoemas@gmail.com>
 * @author    XOOPS Module Development Team
 * @link      https://github.com/XoopsModules25x/xforms
 * @since     2.00
 */

use XoopsModules\Countdown;
use XoopsModules\Countdown\Helper;
use XoopsModules\Countdown\Utility;

/**
 * {@internal Make sure you PROTECT THIS FILE }}
 */

if ((!defined('XOOPS_ROOT_PATH'))
    || !($GLOBALS['xoopsUser'] instanceof \XoopsUser)
    || !($GLOBALS['xoopsUser']->isAdmin()))
{
    exit('Restricted access' . PHP_EOL);
}

/**
 * Pre-upgrade to prepare module for update from previous versions
 *
 * @param \XoopsModule $module
 * @param string $prev_version version * 100
 *
 * @return bool
 *
 */
function xoops_module_pre_update_countdown(\XoopsModule $module, $prev_version)
{
    //make a copy of the module's database schema
    $moduleDirName = basename(dirname(__DIR__));
    $migrate       = new Xmf\Database\Migrate($moduleDirName);
    $success       = $migrate->saveCurrentSchema();

    return $success ? true : false;
}

/**
 * Upgrade works to update Countdown from previous versions
 *
 * @param \XoopsModule $module
 * @param string $prev_version version * 100
 *
 * @return bool
 *
 */
function xoops_module_update_countdown(\XoopsModule $module, $prev_version)
{
    $moduleDirName = basename(dirname(__DIR__));
    /** @var \XoopsModules\Countdown\Utility $utility */
    $utility      = new Utility();
    $xoopsSuccess = $utility::checkVerXoops($module);
    $phpSuccess   = $utility::checkVerPHP($module);

    /**
     * @var Countdown\Helper $helper
     * @var Countdown\Common\Configurator $configurator
     */
    $helper       = Helper::getInstance();
    $configurator = new Countdown\Common\Configurator();

    //  ---  DELETE OLD FILES ---------------
    $delFileSuccess = true;
    if (count($configurator->oldFiles) > 0) {
        foreach (array_keys($configurator->oldFiles) as $i) {
            $tempFile = $GLOBALS['xoops']->path('modules/' . $moduleDirName . $configurator->oldFiles[$i]);
            if (is_file($tempFile)) {
                $delFileSuccess = $delFileSuccess && unlink($tempFile);
            }
        }
    }

    //  ---  DELETE OLD FOLDERS ---------------
    xoops_load('XoopsFile');
    $delFolderSuccess = true;
    if (count($configurator->oldFolders) > 0) {
        foreach (array_keys($configurator->oldFolders) as $i) {
            $tempFolder = $GLOBALS['xoops']->path('modules/' . $moduleDirName . $configurator->oldFolders[$i]);
            /** @var \XoopsObjectHandler $folderHandler */
            $folderHandler = \XoopsFile::getHandler('folder', $tempFolder);
            $delFolderSuccess = $delFolderSuccess && $folderHandler->delete($tempFolder);
        }
    }

    //  ---  CREATE FOLDERS ---------------
    $createFolderSuccess = true;
    if (count($configurator->uploadFolders) > 0) {
        foreach (array_keys($configurator->uploadFolders) as $i) {
            $createFolderSuccess = $createFolderSuccess && $utility::createFolder($configurator->uploadFolders[$i]);
        }
    }

    //  ---  COPY blank.png FILES ---------------
    $copyFileSuccess = true;
    if (count($configurator->copyBlankFiles) > 0) {
        $file = dirname(__DIR__) . '/assets/images/blank.png';
        foreach (array_keys($configurator->copyBlankFiles) as $i) {
            $dest = $configurator->copyBlankFiles[$i] . '/blank.png';
            $copyFileSuccess = $copyFileSuccess && $utility::copyFile($file, $dest);
        }
    }

    return $xoopsSuccess && $phpSuccess && $delFileSuccess && $delFolderSuccess && $createFolderSuccess && $copyFileSuccess;
}
