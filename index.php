<?php
require_once __DIR__ . '/header.php';

$op    = '';
$sort  = '';
$order = '';

if (isset($_GET['op'])) {
    $op = $_GET['op'];
}

if (isset($_POST['cmdAddCountdown'])) {
    $op = 'cmdAddCountdown';
}

if (isset($_POST['cmdEditCountdown'])) {
    $op = 'cmdEditCountdown';
}

if (isset($_POST['cmdRemoveCountdown'])) {
    $op = 'cmdRemoveCountdown';
}

if ($xoopsUser) {
    $uid = $xoopsUser->getVar('uid');
} else {
    redirect_header(XOOPS_URL . '/user.php', 3, _NOPERM);
}

switch ($op) {
    case 'add':
        $GLOBALS['xoopsOption']['template_main'] = 'countdown_add.tpl';            // Set template
        require XOOPS_ROOT_PATH . '/header.php';                   //Include the page header
        addCountdown($uid);
        require XOOPS_ROOT_PATH . '/footer.php';                   //Include the page footer
        break;
    case 'cmdAddCountdown':
        cmdAddCountdown($_POST, $uid);                                        //Add a new countdown
    // no break
    case 'cmdEditCountdown':
        cmdEditCountdown($_POST, $uid);                                        //Edit a countdown
    // no break
    case 'cmdRemoveCountdown':
        cmdRemoveCountdown($_POST, $uid);                                    //Remove a countdown
    // no break
    case 'edit':
        $GLOBALS['xoopsOption']['template_main'] = 'countdown_edit.tpl';        //Set template
        require XOOPS_ROOT_PATH . '/header.php';                            //Include the page header
        editCountdown($uid, $_GET['id']);
        require XOOPS_ROOT_PATH . '/footer.php';                            //Include the page footer
        break;
    default:
        $GLOBALS['xoopsOption']['template_main'] = 'countdown_index.tpl';        // Set template
        require XOOPS_ROOT_PATH . '/header.php';                   //Include the page header
        $hCountdown = xoops_getModuleHandler('countdown', 'countdown');

        //Determine which column to sort on
        if (isset($_GET['sort'])) {
            $sort = $_GET['sort'];
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
        } else {
            $sort = 'name';
        }

        if (isset($_GET['order'])) {
            $order = $_GET['order'];
            if ('ASC' === $order) {
                $order = 'DESC';
            } else {
                $order = 'ASC';
            }
        } else {
            $oder = 'ASC';
        }

        $crit = new CriteriaCompo(new Criteria('uid', $uid));

        if ('all' === $op) {
            //Do nothing, we want to view all
        } elseif ('expired' === $op) {
            $crit->add(new Criteria('enddatetime', time(), '<='));
        } else {
            //This is the default action, to hide anything expired
            $crit->add(new Criteria('enddatetime', time(), '>='));
        }
        $crit->setSort($sort);
        $crit->setOrder($order);

        if (!$events = $hCountdown->getEventsByUser($crit)) {
            //Do Nothing...yet
        }

        foreach ($events as $event) {
            $description = $event->getVar('description');
            if (strlen($description) >= 50) {
                $description = xoops_substr($description, 0, 50);
            }

            $cd_events[] = [
                'id'            => $event->getVar('id'),
                'uid'           => $event->getVar('uid'),
                'name'          => $event->getVar('name'),
                'description'   => $description,
                'enddatetime'   => date('F j, Y, g:i a', $event->getVar('enddatetime')),
                'remainingtime' => $event->remaining()
            ];
        }
        unset($events);

        if (!isset($cd_events)) {
            $cd_events = null;
        }

        $xoopsTpl->assign('cd_events', $cd_events);
        $xoopsTpl->assign('cd_sort_order', $order);
        require XOOPS_ROOT_PATH . '/footer.php';                   //Include the page footer
        break;
}

/**
 * @param $uid
 */
function addCountdown($uid)
{
    global $xoopsTpl;

    if ($uid <= 0) {
        redirect_header(XOOPS_URL . '/user.php', 3, _NOPERM);
    } else {
        $xoopsTpl->assign('cd_current_file', basename(__FILE__));
        $xoopsTpl->assign('cd_current_time', formatTimestamp(time(), 'F j, Y, g:i a'));
        $xoopsTpl->assign('hour_dropdown', DrawHourCombo());
        $xoopsTpl->assign('minute_dropdown', DrawMinuteCombo());
        $xoopsTpl->assign('ampm_dropdown', DrawAMPMCombo());

        //Start the output buffer
        ob_start();
        include_once XOOPS_ROOT_PATH . '/include/calendarjs.php';

        $datetime_js = ob_get_contents();
        $xoopsTpl->assign('xoops_module_header', $datetime_js);
        $xoopsTpl->assign('current_date', date('Y-m-d', time()));
        ob_clean();
    }
}

/**
 * @param $postvars
 * @param $uid
 */
function cmdEditCountdown($postvars, $uid)
{
    $hCountdown = xoops_getModuleHandler('countdown', 'countdown');
    $oCountdown = $hCountdown->create();

    $bHasDate = false;
    $bPM      = false;

    $oCountdown->setVar('id', $postvars['txtCountdownID']);
    $oCountdown->setVar('uid', $uid);
    $oCountdown->setVar('name', $postvars['txtName']);
    $oCountdown->setVar('description', $postvars['txtDescription']);

    if (isset($postvars['dtDateTime'])) {
        $split_date = explode('-', $postvars['dtDateTime']);
    }

    if (3 == count($split_date)) {
        $month    = $split_date[1];
        $day      = $split_date[2];
        $year     = $split_date[0];
        $bHasDate = true;
    }

    $bPM = (!$postvars['cboAMPM']);

    //If it is PM then add 12 hours to the time
    if (false === $bPM) {
        $hours = $postvars['cboHour'];
    } else {
        $hours = $postvars['cboHour'] + 12;
    }

    $minutes = $postvars['cboMinute'];
    $seconds = 0;

    if ('24' == $hours) {
        $day -= 1;
    }

    if ($bHasDate) {
        global $xoopsUser;

        $userTimezone = $xoopsUser->getVar('timezone_offset');
        $iDate        = mktime($hours, $minutes, $seconds, $month, $day, $year);
        $iDate        = userTimeToServerTime($iDate, $userTimezone);

        $oCountdown->setVar('enddatetime', $iDate);
        if ($hCountdown->insert($oCountdown)) {
            $message = 'Countdown updated successfully!';
        } else {
            $message = 'Errors while saving Countdown.';
        }
    } else {
        $message = 'Date format is incorrect.' . "\n" . 'Countdown was not saved.';
    }

    redirect_header('index.php', 3, $message);
}

/**
 * @param $postvars
 * @param $uid
 */
function cmdRemoveCountdown($postvars, $uid)
{
    $hCountdown = xoops_getModuleHandler('countdown', 'countdown');
    $oCountdown =& $hCountdown->get($postvars['txtCountdownID']);
    if ($hCountdown->delete($oCountdown)) {
        $sMessage = 'Countdown removed successfully!';
    } else {
        $sMessage = 'Errors while removing countdown.';
    }

    redirect_header('index.php', 3, $sMessage);
}

/**
 * @param $postvars
 * @param $uid
 */
function cmdAddCountdown($postvars, $uid)
{
    $hCountdown = xoops_getModuleHandler('countdown', 'countdown');
    $oCountdown = $hCountdown->create();

    $bHasDate = false;
    $bPM      = false;

    //Set the object's properties
    $oCountdown->setVar('uid', $uid);
    $oCountdown->setVar('name', $postvars['txtName']);
    $oCountdown->setVar('description', $postvars['txtDescription']);

    if (isset($postvars['dtDateTime'])) {
        $split_date = explode('-', $postvars['dtDateTime']);
    }

    if (3 == count($split_date)) {
        $month    = $split_date[1];
        $day      = $split_date[2];
        $year     = $split_date[0];
        $bHasDate = true;
    }

    $bPM = (!$postvars['cboAMPM']);

    //If it is PM then add 12 hours to the time
    if (false === $bPM) {
        $hours = $_POST['cboHour'];
    } else {
        $hours = $_POST['cboHour'] + 12;
    }

    $minutes = $_POST['cboMinute'];
    $seconds = 0;

    if ('24' == $hours) {
        $day -= 1;
    }

    if ($bHasDate) {
        global $xoopsUser;

        $userTimezone = $xoopsUser->getVar('timezone_offset');
        $iDate        = mktime($hours, $minutes, $seconds, $month, $day, $year);
        $iDate        = userTimeToServerTime($iDate, $userTimezone);

        $oCountdown->setVar('enddatetime', $iDate);
        if ($hCountdown->insert($oCountdown)) {
            $message = 'Countdown added successfully!';
        } else {
            $message = 'Errors while saving Countdown.';
        }
    } else {
        $message = 'Date format is incorrect.' . "\n" . 'Countdown not saved.';
    }

    redirect_header('index.php', 3, $message);
}

/**
 * @param $uid
 * @param $countdownID
 */
function editCountdown($uid, $countdownID)
{
    global $xoopsTpl;

    if ($uid <= 0) {
        redirect_header(XOOPS_URL . '/user.php', 3, _NOPERM);
    } elseif ($countdownID <= 0) {
        redirect_header('index.php?op=add', 3, _NOPERM);
    } else {
        $hCountdown = xoops_getModuleHandler('countdown', 'countdown');
        $oCountdown = $hCountdown->get($countdownID);
        $xoopsTpl->assign('cd_current_file', basename(__FILE__));

        //Start the output buffer
        ob_start();
        $jstime = formatTimestamp('F j Y, H:i:s', $oCountdown->getVar('enddatetime'));
        include_once XOOPS_ROOT_PATH . '/include/calendarjs.php';

        $datetime_js = ob_get_contents();
        ob_clean();

        $xoopsTpl->assign('xoops_module_header', $datetime_js);
        $xoopsTpl->assign('countdown_id', $oCountdown->getVar('id'));
        $xoopsTpl->assign('countdown_name', $oCountdown->getVar('name'));
        $xoopsTpl->assign('countdown_description', $oCountdown->getVar('description'));
        $xoopsTpl->assign('countdown_enddatetime', date('Y-m-d', $oCountdown->getVar('enddatetime')));

        //echo date("i", $oCountdown->getVar('enddatetime'));

        $xoopsTpl->assign('hour_dropdown', DrawHourCombo(date('h', $oCountdown->getVar('enddatetime'))));
        $xoopsTpl->assign('minute_dropdown', DrawMinuteCombo(date('i', $oCountdown->getVar('enddatetime'))));
        $xoopsTpl->assign('ampm_dropdown', DrawAMPMCombo(date('A', $oCountdown->getVar('enddatetime'))));
    }
}

/**
 * @param string $lSelect
 * @return string
 */
function DrawHourCombo($lSelect = '-1')
{
    $sTemp    = "<select name='cboHour'>";
    $selected = '';

    for ($i = 1; $i <= 12; $i++) {
        if ($lSelect == $i) {
            $selected = 'SELECTED';
        } else {
            $selected = '';
        }
        $sTemp .= '<option value="' . $i . '" ' . $selected . '>' . $i . '</option>';
    }
    $sTemp .= '</select>';

    return $sTemp;
}

/**
 * @param string $lSelect
 * @return string
 */
function DrawMinuteCombo($lSelect = '-1')
{
    $sTemp    = "<select name='cboMinute'>";
    $selected = '';
    $lSum     = 0;

    for ($i = 0; $lSum <= 50; $i++) {
        if (0 == $i) {
            $sTemp .= '<option value="' . '00' . '" ' . $selected . '>00</option>';
        } else {
            $lSum += 5;

            if ($lSelect == $lSum) {
                $selected = 'SELECTED';
            } else {
                $selected = '';
            }

            $sTemp .= '<option value="' . $lSum . '" ' . $selected . '>' . $lSum . '</option>';
        }
    }
    $sTemp .= '</select>';

    return $sTemp;
}

/**
 * @param string $sSelect
 * @return string
 */
function DrawAMPMCombo($sSelect = 'AM')
{
    $sTemp = "<select name='cboAMPM'>";

    if ('AM' === $sSelect) {
        $sTemp .= '<option value="0" SELECTED>AM</option>';
    } else {
        $sTemp .= '<option value="0">AM</option>';
    }

    if ('PM' === $sSelect) {
        $sTemp .= '<option value="1" SELECTED>PM</option>';
    } else {
        $sTemp .= '<option value="1">PM</option>';
    }

    $sTemp .= '</select>';

    return $sTemp;
}

/**
 * @param $obj
 */
function DrawObject($obj)
{
    echo '<pre>';
    print_r($obj);
    echo '</pre>';
}
