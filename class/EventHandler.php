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
 * Event Object Handler Class
 *
 */
class EventHandler extends \XoopsPersistableObjectHandler
{
    var $dbtable;
    /**
     * Class constructor
     *
     * @param \XoopsDatabase $db
     * @return void
     */
    function __construct(&$db = null)
    {
        $this->dbtable = 'countdown_events';
        parent::__construct($db, 'countdown_events', Event::class, 'id', 'name');
    }

    /**
     * Get all user events that meet criteria
     *
     * @param \CriteriaElement $criteria
     * @param bool             $id_as_key
     * @return array
     */
    public function getEventsByUser($criteria, $id_as_key = false)
    {
        $objArray = $this->getAll($criteria, null, true, $id_as_key);
        $arr = (is_array($objArray)) ? $objArray : [];
        /*
        $sql = $this->_selectQuery($criteria, true);
        if (is_object($criteria)) {
            $limit = $criteria->getLimit();
            $start = $criteria->getStart();
        }

        $ret = $this->db->query($sql, $limit, $start);

        $arr = [];
        while ($temp = $this->db->fetchArray($ret)) {
            $countdownEvent = $this->create();
            $countdownEvent->assignVars($temp);
            if ($id_as_key) {
                $arr[$countdownEvent->getVar('id')] = $countdownEvent;
            } else {
                $arr[] = $countdownEvent;
            }
            unset($countdownEvent);
        }
        */
        return $arr;
    }

    /**
     * @param null $criteria
     * @return string
     */
    public function _selectQuery(\CriteriaElement $criteria = null)
    {

        $sql = sprintf('SELECT * FROM %s', $this->db->prefix($this->dbtable));

        if (isset($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
            $sql .= ' ' . $criteria->renderWhere();
            if ('' != $criteria->getSort()) {
                $sql .= ' ORDER BY ' . $criteria->getSort() . ' ' . $criteria->getOrder();
            }
        }
        return $sql;
    }
}
