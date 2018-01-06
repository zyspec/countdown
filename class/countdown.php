<?php

/**
 * Class countdownCountdown
 */
class countdownCountdown extends XoopsObject
{
    /**
     * countdownCountdown constructor.
     * @param null $id
     */
    public function __construct($id = null)
    {
        //function initVar($key, $data_type, $value = null, $required = false, $maxlength = null, $options = '')
        $this->initVar('id', XOBJ_DTYPE_INT, null, true);
        $this->initVar('uid', XOBJ_DTYPE_INT, null, true);                      // will store Xoops user id
        $this->initVar('name', XOBJ_DTYPE_TXTBOX, null, true, 50);
        $this->initVar('description', XOBJ_DTYPE_TXTAREA, null, true);
        $this->initVar('enddatetime', XOBJ_DTYPE_INT, null, true);

        if (isset($id)) {
            if (is_array($id)) {
                $this->assignVars($id);
            }
        } else {
            $this->setNew();
        }
    }

    /**
     * @return bool
     */
    public function isNew()
    {
        return ($this->getVar('id') < 1);
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
        return countdownFormatTime($this->getVar('enddatetime') - time());
    }
}    //End of countdown class

/**
 * Class countdownCountdownHandler
 */
class countdownCountdownHandler extends XoopsPersistableObjectHandler
{
    public $db;
    public $classname = countdowncountdown::class;
    public $dbtable   = 'countdown_events';

    /**
     * countdownCountdownHandler constructor.
     * @param $db
     */
    public function __construct(\XoopsDatabase $db)
    {
        parent::__construct($db, 'countdown_events', countdowncountdown::class, 'id', 'id');
    }

    /**
     * @param $db
     * @return countdownHandler
     */
    public static function getInstance($db)
    {
        static $instance;
        if (!isset($instance)) {
            $instance = new static($db);
        }
        return $instance;
    }

    /**
     * @param      $crit
     * @param bool $id_as_key
     * @return array
     */
    public function getEventsByUser($crit, $id_as_key = false)
    {
        $sql = $this->_selectQuery($crit, true);
        if (is_object($crit)) {
            $limit = $crit->getLimit();
            $start = $crit->getStart();
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
        return $arr;
    }

    /**
     * @param null $criteria
     * @return string
     */
    public function _selectQuery($criteria = null)
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
