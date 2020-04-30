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
 * @package   \XoopsModules\Countdown
 * @license   https://www.gnu.org/licenses/gpl-2.0.html GNU Public License
 * @copyright Copyright (c) 2001-2020 {@link https://xoops.org XOOPS Project}
 * @author    XOOPS Module Development Team
 * @link      https://github.com/XoopsModules25x/countdown
 * @since     0.30
 */

use XoopsModules\Countdown\Helper;

$moduleDirName = basename(__DIR__);

require dirname(dirname(__DIR__)) . '/mainfile.php';
require __DIR__ . '/preloads/autoloader.php';

/** @var \Xmf\Module\Helper $helper */
$helper = Helper::getInstance();
