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
 * @package   \XoopsModules\Xforms\blocks
 * @author    XOOPS Module Development Team
 * @copyright Copyright (c) 2001-2019 {@link http://xoops.org XOOPS Project}
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU Public License
 * @since     2.00
 */
use XoopsModules\Countdown\Helper;

require_once dirname(dirname(dirname(__DIR__))) . '/mainfile.php';
require dirname(__DIR__) . '/preloads/autoloader.php';


// Instantiate module helper
/** @var \XoopsModules\Countdown\Helper $helper */
$helper = Helper::getInstance();

// Load language files
$helper->loadLanguage('modinfo');
$helper->loadLanguage('main');

/**
 * Display the countdown stats block
 *
 * @param array $options
 *
 * @return array $block[] = array('title'=> item title, 'desc' => description), etc.
 */
function b_countdown_stats_show($options) {
    // Instantiate module helper
    /** @var \XoopsModules\Countdown\Helper $helper */
    $helper = Helper::getInstance();

    $block = [];
    /** @var \XoopsModules\Countdown\EventHandler $eventHandler */
    $eventHandler   = $helper::getInstance()->getHandler('Event');
    $total_count    = $eventHandler->getCount();
    $active_count   = $eventHandler->getCount(new \Criteria('enddatetime', time(), '>'));
    $inactive_count = $total_count - $active_count;

    $criteria     = new \Criteria('uid', 0, '>'); // gets everything
    $cd_list      = $eventHandler->getAll($criteria, ['id', 'uid'], false);
    $all_users    = array_column($cd_list, 'uid');
    $unique_users = array_unique($all_users);
    $user_count   = count($unique_users);
    if (0 < $total_count) {
        $block = [
            'show_active'    => $options[0] ? true : false,
            'show_inactive'  => $options[1] ? true : false,
            'show_total'     => $options[2] ? true : false,
            'show_users'     => $options[3] ? true : false,
            'active_count'   => $active_count,
            'inactive_count' => $inactive_count,
            'total_count'    => $total_count,
            'user_count'     => $user_count
        ];
    }
    return $block;
}

    /**
 *Create HTML for stats block editing functionality
 *
 * @param array $options [0] = sort, [1] = number to show
 *
 * @return string HTML to display
 */
function b_countdown_stats_edit($options) {

    $opt0SelY = $options[0] ? ' checked' : '';
    $opt0SelN = !$options[0] ? ' checked' : '';

    $opt1SelY = $options[1] ? ' checked' : '';
    $opt1SelN = !$options[1] ? ' checked' : '';

    $opt2SelY = $options[2] ? ' checked' : '';
    $opt2SelN = !$options[2] ? ' checked' : '';

    $opt3SelY = $options[3] ? ' checked' : '';
    $opt3SelN = !$options[3] ? ' checked' : '';

    $form = '<div>' . _MB_COUNTDOWN_SHOW . ' ' . _MB_COUNTDOWN_ACTIVE . ":&nbsp;&nbsp;"
          . '<label  style="vertical-align: middle; "for="show_active_0">' . _NO
          . '<input type="radio" name="options[0]" value="0" id="show_active_0" style="margin-right: 1em;" ' . $opt0SelN . '></label>'
          . '<label for="show_active_1">' . _YES
          . '<input type="radio" name="options[0]" value="1" id="show_active_1" style="margin-right: 1em;"' . $opt0SelY . '></label>'
          . '</div>';

    $form .= '<div>' . _MB_COUNTDOWN_SHOW . ' ' . _MB_COUNTDOWN_INACTIVE . ':&nbsp;&nbsp;'
           . '<label  style="vertical-align: middle; "for="show_inactive_0">' . _NO
           . '<input type="radio" name="options[1]" value="0" id="show_inactive_0" style="margin-right: 1em;" ' . $opt1SelN . '></label>'
           . '<label for="show_inactive_1">' . _YES
           . '<input type="radio" name="options[1]" value="1" id="show_inactive_1" style="margin-right: 1em;"' . $opt1SelY . '></label>'
           . '</div>';

    $form .= '<div>' . _MB_COUNTDOWN_SHOW . ' ' . _MB_COUNTDOWN_TOTAL . '&nbsp;&nbsp;'
           . '<label  style="vertical-align: middle; "for="show_total_0">' . _NO
           . '<input type="radio" name="options[2]" value="0" id="show_total_0" style="margin-right: 1em;" ' . $opt2SelN . '></label>'
           . '<label for="show_total_1">' . _YES
           . '<input type="radio" name="options[2]" value="1" id="show_total_1" style="margin-right: 1em;"' . $opt2SelY . '></label>'
           . "</div>";

    $form .= '<div>' . _MB_COUNTDOWN_SHOW . ' ' . _MB_COUNTDOWN_USERS . '&nbsp;&nbsp;'
           . '<label  style="vertical-align: middle; "for="show_users_0">' . _NO
           . '<input type="radio" name="options[3]" value="0" id="show_users_0" style="margin-right: 1em;" ' . $opt3SelN . '></label>'
           . '<label for="show_users_1">' . _YES
           . '<input type="radio" name="options[3]" value="1" id="show_users_1" style="margin-right: 1em;"' . $opt3SelY . '></label>'
           . "</div>";

   return $form;
}
