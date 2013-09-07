<?php defined('SYSPATH') OR die('No direct access allowed.');

/**
 * Base Controller
 * Provider Basic Dao Operation
 *
 * @packaged libraries
 * @author renwenyue@baidu.com
 **/

class Basic_Ctrl extends Controller {

	protected $session = null;

	protected $timestamp = null;

	public function __construct() {
		parent::__construct();

		$this->timestamp = date('Y-m-d H:i:s');

	}

	public function getSelfFuncs($selfName) {

		$selfName .= '_Controller';

		$reflection = new ReflectionClass($selfName);

		$mtds = ($reflection->getMethods(ReflectionMethod::IS_PUBLIC));

		$arr = array();

		foreach($mtds as $method) {
			if(strtolower($method->class) != strtolower($selfName)) {
				
				continue;

			}	

			if(substr($method->name, 0, 2) == '__') {

				continue;

			}

			$arr[] = $method->name;

		}

		echo json_encode($arr);

	}

}
