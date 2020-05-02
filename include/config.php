<?php
/*
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */
/**
 * Module: Countdown
 *
 * @package   \XoopsModules\Countdown
 * @copyright Copyright (c) 2001-2020 {@link https://xoops.org XOOPS Project}
 * @license   https://www.gnu.org/licenses/gpl-2.0.html GNU Public License
 * @author    XOOPS Development Team
 * @link      https://github.com/XoopsModules25x/countdown
 */

$moduleDirName      = basename(dirname(__DIR__));
$moduleDirNameUpper = mb_strtoupper($moduleDirName);
return (object)[
    'name'           => mb_strtoupper($moduleDirName) . ' Module Configurator',
    'paths'          => [
        'dirname'    => $moduleDirName,
        'admin'      => XOOPS_ROOT_PATH . '/modules/' . $moduleDirName . '/admin',
        'modPath'    => XOOPS_ROOT_PATH . '/modules/' . $moduleDirName,
        'modUrl'     => XOOPS_URL . '/modules/' . $moduleDirName,
        'uploadPath' => XOOPS_UPLOAD_PATH . '/' . $moduleDirName,
        'uploadUrl'  => XOOPS_UPLOAD_URL . '/' . $moduleDirName,
    ],
    'icons'          => [
    //    'icons' => [
        //'edit'    => "<img src='" . $pathIcon16 . "/edit.png'  alt=" . _EDIT . "' align='middle'>",
        //'delete'  => "<img src='" . $pathIcon16 . "/delete.png' alt='" . _DELETE . "' align='middle'>",
        //'add'     => "<img src='" . $pathIcon16 . "/add.png' alt='" . _ADD . "' align='middle'>",
        //'0'       => "<img src='" . $pathIcon16 . "/0.png' alt='" . 0 . "' align='middle'>",
        //'1'       => "<img src='" . $pathIcon16 . "/1.png' alt='" . 1 . "' align='middle'>",
    ],
    'uploadFolders'  => [
        //        constant($moduleDirNameUpper . '_UPLOAD_PATH'),
        //        constant($moduleDirNameUpper . '_UPLOAD_PATH') . '/category',
        //        constant($moduleDirNameUpper . '_UPLOAD_PATH') . '/screenshots',
    ],
    'copyBlankFiles' => [
        //        constant($moduleDirNameUpper . '_UPLOAD_PATH'),
        //        constant($moduleDirNameUpper . '_UPLOAD_PATH') . '/category',
        //        constant($moduleDirNameUpper . '_UPLOAD_PATH') . '/screenshots',
    ],
    'copyTestFolders' => [
        //        constant($moduleDirNameUpper . '_UPLOAD_PATH'),
        //        [
        //            constant($moduleDirNameUpper . '_PATH') . '/testdata/images',
        //            constant($moduleDirNameUpper . '_UPLOAD_PATH') . '/images',
        //        ]
    ],
    'templateFolders' => [
        '/templates/',
        //'/templates/admin/',
        //'/templates/blocks/',
    ],
    'oldFiles'        => [
        '/images/logo.png',
        '/countdown_screeny.png',
        '/class/countdown.php',
        '/templates/countdown_add.html',
        '/templates/countdown_edit.html',
        '/templates/countdown_index.html',
        '/templates/countdown_add.tpl',
        '/templates/countdown_edit.tpl',
    ],
    'oldFolders'      => [
        '/images',
        '/extras/themes/bootstrap'
        //'/css',
        //'/js',
        //'/tcpdf',
    ],
    'renameTables'    => [//         'XX_archive'     => 'ZZZZ_archive',
    ],
    'moduleStats'  => [
    ],
    'modCopyright' => "<a href='https://xoops.org' target='_blank'>"
    . "<img src='" . \Xmf\Module\Admin::iconUrl('xoopsmicrobutton.gif') . "' alt='XOOPS Project - " . ucfirst($moduleDirName) . "' title='XOOPS Project - " . ucfirst($moduleDirName) . "'></a>"
];
