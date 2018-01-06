<?php
class countdownCountdown extends XoopsObject
{   
   function countdownCountdown($id = null)
	{
   	//function initVar($key, $data_type, $value = null, $required = false, $maxlength = null, $options = '')
    	$this->initVar('id', XOBJ_DTYPE_INT, null, true);
      $this->initVar('uid', XOBJ_DTYPE_INT, null, true);                      // will store Xoops user id
      $this->initVar('name', XOBJ_DTYPE_TXTBOX, null, true, 50);
      $this->initVar('description', XOBJ_DTYPE_TXTAREA, null, true);
      $this->initVar('enddatetime', XOBJ_DTYPE_INT, null, true);
       	
      if (isset($id)) 
      {
			if (is_array($id))
			{
				$this->assignVars($id);
			}
		} else {
			$this->setNew();
		} 
	}
   
   function isNew()
   {
   	return ($this->getVar('id') < 1);
   }
   
	function endtime($format="l")
	{
		return formatTimestamp($this->getVar('enddatetime'), $format);
	}
    
   function remaining()
   {
   	return countdownFormatTime($this->getVar('enddatetime') - time());
	}
    
}	//End of countdown class

class countdownCountdownHandler extends XoopsObjectHandler
{
	var $_db;
	var $classname = 'countdowncountdown';
	var $_dbtable = 'countdown_events';
	
	function countdownCountdownHandler(&$db) 
	{
		$this->_db = $db;
	}
	
	function &getInstance(&$db)
	{
		static $instance;
		if (!isset($instance)) {
			$instance = new countdownHandler($db);
		}
		return $instance;
	}
	
	function &create()
	{
		return new $this->classname();
	}
	
	function &get($id)
	{
		$id = intval($id);
		if ($id > 0) {
			$sql = $this->_selectQuery(new Criteria('id', $id));
			if (!$result = $this->_db->query($sql)) {
				return false;
			}
			$numrows = $this->_db->getRowsNum($result);
			if ($numrows == 1) {
				$obj = new $this->classname($this->_db->fetchArray($result));
				return $obj;
			}
		}
		return false;
	}
		
	function getCount($criteria = null)
	{
		$sql = 'SELECT COUNT(*) FROM '.$this->_db->prefix($this->_dbtable);
		if (isset($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
			$sql .= ' '.$criteria->renderWhere();
		}
		if (!$result =& $this->_db->query($sql)) {
			return 0;
		}
		list($count) = $this->_db->fetchRow($result);
		return $count;
	}
	
	function &getObjects($criteria = null, $id_as_key = false)
	{
		$ret    = array();
		$limit  = $start = 0;
		$sql    = $this->_selectQuery($criteria);
		if (isset($criteria)) {		
			$limit = $criteria->getLimit();
			$start = $criteria->getStart();
		}

		$result = $this->_db->query($sql, $limit, $start);
		// If no records from db, return empty array
		if (!$result) {
			return $ret;
		}
		
		// Add each returned record to the result array
		while ($myrow = $this->_db->fetchArray($result)) {
			$obj = new $this->classname($myrow);
			if ($id_as_key) {
			    $ret[$obj->getVar('id')] =& $obj;
			} else {
			    $ret[] =& $obj;
			}
			unset($obj);
		}
		return $ret;
	}
	
	function getEventsByUser($crit, $id_as_key = false) 
	{
	    
        $sql = $this->_selectQuery($crit, true);
        if (is_object($crit)) {
            $limit = $crit->getLimit();
            $start = $crit->getStart();
        }
        
        $ret = $this->_db->query($sql, $limit, $start);
        $arr = array();
        while ($temp = $this->_db->fetchArray($ret)) {
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
    
    function insert(&$obj, $force = false)
	{
		// Make sure object is of correct type
		if (get_class($obj) != $this->classname) {
			return false;
		}
		
		// Make sure object needs to be stored in DB
		if (!$obj->isDirty()) {
			return true;
		}
		
		// Make sure object fields are filled with valid values
		if (!$obj->cleanVars()) {
			return false;
		}
		
		// Copy all object vars into local variables
		foreach ($obj->cleanVars as $k => $v) {
			${$k} = $v;
		}
		
		// Create query for DB update
		if ($obj->isNew()) {
			// Determine next auto-gen ID for table
			$id = $this->_db->genId($this->_db->prefix($this->_dbtable).'_uid_seq');
			$sql = sprintf("INSERT INTO %s (id, uid, name, description, enddatetime) 
			                VALUES (%u, %u, %s, %s, %u)", $this->_db->prefix($this->_dbtable), $id,
			                $uid, $this->_db->quoteString($name), $this->_db->quoteString($description), $enddatetime);
		} else {
			$sql = sprintf("UPDATE %s SET uid = %u, name = %s, description = %s, enddatetime = %u WHERE id = %u", $this->_db->prefix($this->_dbtable), 
			                $uid, $this->_db->quoteString($name), $this->_db->quoteString($description), $enddatetime, $id);
		}
		
		// Update DB
		if (false != $force) {
			$result = $this->_db->queryF($sql);
		} else {
			$result = $this->_db->query($sql);
		}
		
		if (!$result) {
			return false;
		}
		
		//Make sure auto-gen ID is stored correctly in object
		if (empty($id)) {
			$id = $this->_db->getInsertId();
		}
		$obj->assignVar('id', $id);
		return true;
	}
	
	function _selectQuery($criteria = null)
	{
    	$sql = sprintf('SELECT * FROM %s', $this->_db->prefix($this->_dbtable));
    	
	    if (isset($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
			$sql .= ' '.$criteria->renderWhere();
			if ($criteria->getSort() != '') {
				$sql .= ' ORDER BY '.$criteria->getSort().' '.$criteria->getOrder();
			}
		}
		return $sql;
	}
	
	function delete(&$obj, $force = false)
	{
		if (get_class($obj) != $this->classname) {
			return false;
		}
		
		$sql = sprintf("DELETE FROM %s WHERE id = %u", $this->_db->prefix($this->_dbtable), $obj->getVar('id'));
		if (false != $force) {
			$result = $this->_db->queryF($sql);
		} else {
			$result = $this->_db->query($sql);
		}
		if (!$result) {
			return false;
		}
		return true;
	}
	
	function deleteAll($criteria = null)
	{
		$sql = 'DELETE FROM '.$this->_db->prefix($this->_dbtable);
		if (isset($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
			$sql .= ' '.$criteria->renderWhere();
		}
		if (!$result = $this->_db->query($sql)) {
			return false;
		}
		return true;
	}
}
	
	
?>