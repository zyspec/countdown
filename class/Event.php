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
 * Module: Countdown
 *
 * @package   \XoopsModules\Countdown
 * @license   https://www.gnu.org/licenses/gpl-2.0.html GNU Public License
 * @copyright Copyright (c) 2001-2020 {@link https://xoops.org XOOPS Project}
 * @author    XOOPS Module Development Team
 * @link      https://github.com/XoopsModules25x/countdown
 * @since     0.30
 */

use XoopsModules\Countdown\CdCalendar;

/**
 * Class Countdown\Event
 */
class Event extends \XoopsObject
{
    /**
     * Countdown Event constructor.
     * @param null $id
     */
    public function __construct($id = null)
    {
        parent::__construct();
        $this->initVar('id', XOBJ_DTYPE_INT, null, true);
        $this->initVar('uid', XOBJ_DTYPE_INT, null, true); // stores XOOPS user id
        $this->initVar('name', XOBJ_DTYPE_TXTBOX, null, true, 50);
        $this->initVar('description', XOBJ_DTYPE_TXTAREA, null, true);
        $this->initVar('enddatetime', XOBJ_DTYPE_INT, null, true);
    }

    /**
     * @param string $format
     * @return string
     */
    public function endtime($format = 'l')
    {
        return formatTimestamp($this->getVar('enddatetime'), $format);
    }

    /**
     * @return string
     */
    public function remaining()
    {
        return CdCalendar::formatTime($this->getVar('enddatetime'));
        //return CdCalendar::formatTime($this->getVar('enddatetime') - time());
    }
}    //End of countdown class
