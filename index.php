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

use Xmf\Request;
use XoopsModules\Countdown\Constants;
use XoopsModules\Countdown\CdCalendar;

require_once __DIR__ . '/header.php';

if (!$GLOBALS['xoopsUser'] || !$GLOBALS['xoopsUser'] instanceof \XoopsUser || $GLOBALS['xoopsUser']->isGuest()) {
    redirect_header(XOOPS_URL . '/user.php', Constants::REDIRECT_DELAY_MEDIUM, _NOPERM);
}

$sort  = $order = '';

$op = Request::getCmd('op', '', 'GET');
$op = Request::hasVar('cmdAddCountdown', 'POST') ? 'save' : $op;
$op = Request::hasVar('cmdEditCountdown', 'POST') ? 'save' : $op;
$op = Request::hasVar('cmdRemoveCountdown', 'POST') ? 'remove' : $op;

$uid = $GLOBALS['xoopsUser']->uid();

switch ($op) {
    case 'add':  // add a new countdown
    case 'edit': // edit an existing countdown
        $GLOBALS['xoopsOption']['template_main'] = 'countdown_entry.tpl';
        require XOOPS_ROOT_PATH . '/header.php';

        $cdCal = new CdCalendar();
        $cd_id = Request::getInt('id', 0, 'GET');

        $dtzObj      = new \DateTimeZone((string)($GLOBALS['xoopsUser']->timezone() * 100));
        $dateTimeObj = new \DateTime();
        $dateTimeObj->setTimezone($dtzObj);

        if (0 < $cd_id) {
            /** @var \XoopsModules\Countdown\Helper $helper */
            $eventHandler = $helper->getHandler('Event');
            $eventObj     = $eventHandler->get($cd_id);
            if (!$eventObj instanceof \XoopsModules\Countdown\Event) {
                $helper->redirect('index.php', Constants::REDIRECT_DELAY_MEDIUM, _COUNTDOWN_ERR_BAD_ID);
            } elseif ($uid !== $eventObj->getVar('uid')) {
                $helper->redirect('index.php', Constants::REDIRECT_DELAY_MEDIUM, _COUNTDOWN_ERR_NOT_OWNER);
            }

            $dateTimeObj->setTimestamp($eventObj->getVar('enddatetime'));
            $cd_name = $eventObj->getVar('name');
            $cd_desc = $eventObj->getVar('description');
        } else { // adding new event
            $dateTimeObj->setTimestamp(userTimeToServerTime(time(), $GLOBALS['xoopsUser']->timezone()));
            $dateIntObj  = new \DateInterval('P1D'); // 1 day
            $dateTimeObj->add($dateIntObj);
            $cd_name = '';
            $cd_desc = '';
        }
            $hours   = $dateTimeObj->format('h');
            $minutes = $dateTimeObj->format('i');
            $AMPM    = $dateTimeObj->format('A');
            $endDate = $dateTimeObj->format('m/d/Y');
            $calObj  = new \XoopsFormDateTime('', 'dtDateTime', $size = 15, $dateTimeObj->getTimestamp(), false);
            $cal_ele = $calObj->render();

            /** var \XoopsSecurity $GLOBALS['xoopsSecurity'] */
            $GLOBALS['xoopsTpl']->assign([
                'cd_current_file'       => basename(__FILE__),
                'security_token'        => $GLOBALS['xoopsSecurity']->getTokenHTML(),
                'countdown_id'          => $cd_id,
                'countdown_name'        => $cd_name,
                'countdown_description' => $cd_desc,
                'countdown_enddatetime' => $endDate,
                'cd_current_time'       => formatTimestamp(time(), 'F j, Y, g:i a'),
                'hour_dropdown'         => $cdCal::renderHourCombo($hours),
                'minute_dropdown'       => $cdCal::renderMinuteCombo($minutes),
                'ampm_dropdown'         => $cdCal::renderAMPMCombo($AMPM),
                'cal_element'           => $cal_ele,
            ]);

        //Start the output buffer
        ob_start();
        include_once XOOPS_ROOT_PATH . '/include/calendar.js';
        $datetime_js = ob_get_contents();
        ob_clean();
        break;
    case 'save': // Save either a new countdown or edit an existing countdown event
        // Check to make sure this is from known location w/ token
        if (!$GLOBALS['xoopsSecurity']->check()) {
            $helper->redirect('index.php', Constants::REDIRECT_DELAY_MEDIUM, implode('<br>', $GLOBALS['xoopsSecurity']->getErrors()));
        }
        $inpDate     = Request::getArray('dtDateTime', '', 'POST');
        $dtzObj      = new \DateTimeZone((string)($GLOBALS['xoopsUser']->timezone() * 100));
        $dateTimeObj = \DateTime::createFromFormat(_SHORTDATESTRING, $inpDate['date'], $dtzObj);
        $bPM         = Constants::OPTION_PM == Request::getInt('cboAMPM', Constants::OPTION_AM, 'POST') ? true : false;
        $hours       = Request::getInt('cboHour', 0, 'POST');
        $hours       = $hours % 12; // normalize time to 12 hr clock
        $hours       = $bPM ? $hours + 12 : $hours; // add 12 hrs for PM time
        $minutes     = Request::getInt('cboMinute', 0, 'POST');
        $seconds     = 0;
        $dateTimeObj->setTime($hours, $minutes, $seconds);
        $timestamp = $dateTimeObj->getTimestamp();

        $eventHandler = $helper->getHandler('Event');
        $cd_id          = Request::getInt('txtCountdownID', 0, 'POST');
        $eventObj     = $eventHandler->get($cd_id); // creates object if doesn't exist
        $isNew        = $eventObj->isNew();
        $eventObj->setVars([
            'uid'         => $uid,
            'name'        => Request::getString('txtName', '', 'POST'),
            'description' => Request::getString('txtDescription', '', 'POST'),
            'enddatetime' => $timestamp
        ]);
        $message = $eventHandler->insert($eventObj) ? $isNew ? _COUNTDOWN_MSG_CREATED : _COUNTDOWN_MSG_UPDATED : _COUNTDOWN_ERR_SAVE;
        $helper->redirect('index.php', Constants::REDIRECT_DELAY_MEDIUM, $message);
        break;
    case 'remove': // Remove a countdown event
        $id = Request::getInt('txtCountdownID', 0, 'POST');
        if (!Request::hasVar('ok', 'POST') || 1 !== Request::getInt('ok', 0, 'POST')) {
            $eventObj = $helper->getHandler('Event')->get($id);
            if (!$eventObj instanceof \XoopsModules\Countdown\Event) {
                $helper->redirect('index.php', Constants::REDIRECT_DELEAY_MEDIUM, _COUNTDOWN_ERR_BAD_ID);
            } elseif ($eventObj->getVar('uid') !== $GLOBALS['xoopsUser']->uid()) {
                $helper->redirect('index.php', Constants::REDIRECT_DELAY_MEDIUM, _COUNTDOWN_ERR_NOT_OWNER);
            }
            require XOOPS_ROOT_PATH . '/header.php';
            xoops_confirm(['ok' => Constants::CONFIRM_OK, 'txtCountdownID' => $id, 'cmdRemoveCountdown' => 1], $helper->url('index.php'), sprintf(_COUNTDOWN_MSG_DEL_CONFIRM, $eventObj->getVar('name')), _YES);
            break;
        }
        // check security
        if (!$GLOBALS['xoopsSecurity']->check()) {
            $helper->redirect('index.php', Constants::REDIRECT_DELAY_MEDIUM, implode('<br>', $GLOBALS['xoopsSecurity']->getErrors()));
        }
        $eventHandler = $helper->getHandler('Event');
        $eventObj     = $eventHandler->get(Request::getInt('txtCountdownID', 0, 'POST'));
        $message      = $eventHandler->delete($eventObj) ? _COUNTDOWN_MSG_DELETED  : _COUNTDOWN_ERR_DEL;
        $helper->redirect('index.php', Constants::REDIRECT_DELAY_MEDIUM, $message);
        break;
    default:
        $GLOBALS['xoopsOption']['template_main'] = 'countdown_index.tpl';
        require XOOPS_ROOT_PATH . '/header.php';

        $helper->loadLanguage('modinfo');
        $cdCal = new CdCalendar();

        //Determine which column to sort on
        $sort = Request::hasVar('sort', 'GET') ? '' : 'name';
        $sort = Request::getCmd('sort', $sort, 'GET');
        switch ($sort) {
            case 'name':
                break;
            case 'description':
                break;
            case 'enddatetime':
                break;
            case 'remaining':
                $sort = 'enddatetime';
                break;
            default:
                $sort = 'name, description';
                break;
        }

        $order = Request::getString('order', 'ASC', 'GET');
        $order = 'ASC' == $order ? 'DESC' : 'ASC'; // toggle sort order

        $criteria = new \CriteriaCompo(new Criteria('uid', $uid));

        if ('all' === $op) {
            $sub_title = _MI_MENU_VIEW_ALL;
            //Do nothing, we want to view all
        } elseif ('expired' === $op) {
            $sub_title = _MI_MENU_VIEW_EXPIRED;
            $criteria->add(new Criteria('enddatetime', time(), '<='));
        } else {
            $sub_title = _MI_MENU_VIEW_CURRENT;
            //This is the default action, to hide anything expired
            $criteria->add(new Criteria('enddatetime', time(), '>='));
        }

        $GLOBALS['xoopsTpl']->assign('sub_title', $sub_title);

        $criteria->setSort($sort);
        $criteria->order = $order; // forced write directly to 'order' var due to bug in XOOPS core <= 2.5.10

        $eventHandler  = $helper->getHandler('Event');
        $eventObjArray = $eventHandler->getAll($criteria);
        if (!$events = $eventHandler->getEventsByUser($criteria)) {
            //Do Nothing...yet
        }

        $cd_events = [];
        foreach ($eventObjArray as $eventObj) {
            $description = $eventObj->getVar('description');
            if (Constants::MAXIMUM_DESC_LENGTH <= strlen($description)) {
                $description = xoops_substr($description, 0, Constants::MAXIMUM_DESC_LENGTH);
            }

            $dtzObj      = new \DateTimeZone((string)($GLOBALS['xoopsUser']->timezone() * 100));
            $dateTimeObj = new \DateTime();
            $dateTimeObj->setTimezone($dtzObj);
            $dateTimeObj->setTimestamp($eventObj->getVar('enddatetime'));

            $cd_events[] = [
                'id'            => $eventObj->getVar('id'),
                'uid'           => $eventObj->getVar('uid'),
                'name'          => $eventObj->getVar('name'),
                'description'   => $description,
                'enddatetime'   => $dateTimeObj->format('F j, Y, g:i a'),
//                'enddatetime'   => date('F j, Y, g:i a', $eventObj->getVar('enddatetime')),
                'remainingtime' => $eventObj->remaining()
            ];
        }
        unset($eventObjArray, $eventObj);

        $GLOBALS['xoopsTpl']->assign([
            'cd_events'     => $cd_events,
            'cd_sort_order' => $order
        ]);
        break;
}
require XOOPS_ROOT_PATH . '/footer.php'; //Include the page footer

