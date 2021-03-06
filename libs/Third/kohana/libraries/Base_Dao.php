<?php defined('SYSPATH') OR die('No direct access allowed.');

/**
 * Base Dao 
 * Provide Basic Dao Operations
 *
 * @packaged libraries
 * @author renwenyue@baidu.com
 **/

abstract class Base_Dao extends Model {

	protected $tableName;

	public function __construct() {
		parent::__construct();
	}

	final public function insert($tblName, $arr) {

		return $this->db
			->insert($tblName, $arr)
			->insert_id();

	}
	final public function add($arr) {

		return $this->insert($this->tableName, $arr);

	}

	final public function remove($tblName, $condArr) {

		$status = $this->db
			->from($tblName)
			->where($condArr)
			->delete();

		return count($status);

	}

	final public function del($condArr = array())
	{
		return $this->remove($this->tableName, $condArr);
	}

	final public function select($tblName, $condArr, $orderarr= FALSE) {

		$status = $this->db
			->from($tblName);
		if(is_array($orderarr) && count($orderarr)) {
			$status->orderby($orderarr);
		}
		$ret = $status->where($condArr)
			->select()
			->get();
		return $ret->result_array(false);
		
	}

	final public function get($condArr = array(),$orderarr=FALSE)
	{
		return $this->select($this->tableName, $condArr, $orderarr);
		
	}


	final public function count($condArr = array())
	{
		return $this->db
			->where($condArr)
			->count_records($this->tableName);
	}


	final public function update($tblName, $condArr, $arr) {

		$ret = $this->db
			->from($tblName)
			->where($condArr)
			->set($arr)
			->update();

		return count($ret);

	}

	final public function updateself($condArr, $arr) {
		return $this->update($this->tableName, $condArr, $arr);
	}

	final public function getByPagination($pageCount, $pageSize, $condArr, $orderby, $DESC=TRUE)
	{
		$query = $this->db
			->limit($pageSize, intval( ($pageCount - 1) * (int)$pageSize))
			->orderby($orderby, (bool)$DESC ? 'DESC' : 'ASC');

		if($condArr != array()) {
			$query->where($condArr);
		}

		$ret = $query->get($this->tableName);

		return $ret->result_array(FALSE);
	}



} // END class BaseDao
