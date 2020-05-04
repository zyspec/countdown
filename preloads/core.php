<?php
/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit
 authors. This program is distributed in the hope that it will be useful, but
 WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
 FITNESS FOR A PARTICULAR PURPOSE.
*/
/**
 *
 * @copyright https://xoops.org XOOPS Project
 * @license   https://www.gnu.org/licenses/gpl-2.0.html GNU Public License
 * @author    XOOPS Project <www.xoops.org> <www.xoops.ir>
 */
defined('XOOPS_ROOT_PATH') || exit('Restricted access');

/**
 * Class CountdownCorePreload
 */
class CountdownCorePreload extends \XoopsPreloadItem
{
    /**
     * @var bool session helper
     */
    private static $sessionHelper;

    // to add PSR-4 autoloader
    /**
     * @param mixed $args
     * @return void
     */
    public static function eventCoreIncludeCommonEnd($args)
    {
        require_once __DIR__ . '/autoloader.php';

        /**
         * Sync Countdown users with XOOPS users
         * - remove Countdown users if not a valid XOOPS user
         * - only try once per session, successful or not
         *
         * @var \Xmf\Module\Helper\Session $sessionHelper
         * @var \XoopsModules\Countdown\EventHandler $eventHandler
         */
        $moduleDirName = basename(dirname(__DIR__));
        $sessionHelper = new \Xmf\Module\Helper\Session($moduleDirName);

        if (false === $sessionHelper->get('state')) {
            $eventHandler = new \XoopsModules\Countdown\EventHandler();
            if (false === ($success = $eventHandler->cleanOrphan($GLOBALS['xoopsDB']->prefix('users'), 'uid', 'uid'))) {
                trigger_error('The Countdown Event dB table could not be scrubbed.', E_USER_NOTICE);
            }
            $sessionHelper->set('state', true);
        }
        return;
    }
}
