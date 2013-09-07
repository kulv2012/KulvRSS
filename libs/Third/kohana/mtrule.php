<?php defined('SYSPATH') OR die('No direct access allowed.');

/**
 * Mutix 规则文件存储
 *
 * renwenyue@baidu.com
 * 2012-12-05 19:37:16
 */

class MTRule_Model extends Base_Dao {

	protected $tableName = 'Tbl_MT_Rule';

	protected $logTable = 'Tbl_MT_RuleLog';
    public $st = array();

	public function __construct()
	{
		parent::__construct();
	}

	
	public function getone($id)
	{

		$url = Kohana::config('mutix.baseurl').Kohana::config('mutix.querypath');

		$url.= '?type=getrule&product_name='.$id['product_name'].'&comp_name='.$id['component_name'].'&res_id='.$id['resource_id'];

		Kohana::log('debug', $url);

		$ret = file_get_contents($url);

		return array(

			'szProduct'    => $id['product_name'],
			'szModule'     => $id['component_name'],
			'szResourceId' => $id['resource_id'],
			'szRule'       => $ret

		);	
	}

	public function getall()
	{

		$url = Kohana::config('mutix.baseurl').Kohana::config('mutix.querypath');

		$url.= '?type=getrulelist';

		$ret = file_get_contents($url);

		$ret = json_decode($ret, TRUE);

		if(!count($ret)) return false;

		$tmp = array();

		foreach($ret as $row){

			$row['id'] = base64_encode(json_encode($row));

			$tmp[] = $row;

		}

		return $tmp;
	}

	public function savelog($data)
	{
		$this->insert($this->logTable, $data);
	}

}






















