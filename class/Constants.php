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

/**
 * Interface \XoopsModules\Countdown\Constants
 */
interface Constants
{
    /**#@+
     * Constant definition
     */

    /**
     * AM (Ante meridiem) time option
     */
    const OPTION_AM = 0;
    /**
     * PM (Post meridiem) time option
     */
    const OPTION_PM = 1;
    /**
     * Maximum description length
     */
    const MAXIMUM_DESC_LENGTH = 50;
    /**
     * no delay XOOPS redirect delay (in seconds)
     */
    const REDIRECT_DELAY_NONE = 0;
    /**
     * short XOOPS redirect delay (in seconds)
     */
    const REDIRECT_DELAY_SHORT = 1;
    /**
     * medium XOOPS redirect delay (in seconds)
     */
    const REDIRECT_DELAY_MEDIUM = 3;
    /**
     * long XOOPS redirect delay (in seconds)
     */
    const REDIRECT_DELAY_LONG = 7;
    /**
     * confirm not ok to take action
     */
    const CONFIRM_NOT_OK = 0;
    /**
     * confirm ok to take action
     */
    const CONFIRM_OK = 1;
    /**#@-*/
}
