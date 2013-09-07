<?php defined('SYSPATH') OR die('No direct access allowed.');

class YunJin {

	public static function getModel($modelName) 
	{
		$modelName .= '_Model';
		return new $modelName;
	}

	public static function getService($svcName)
	{

		$svcName = ucfirst($svcName);
		$svcName .= '_Service';

		$m = new ReflectionMethod($svcName, '__construct');

		if($m->isPublic()) {

			return new $svcName;

		} else {

			$instance = NULL;

			//unless PHP Ver >= 5.3, otherwise eval is a best workaround til now
			eval('$instance = '.$svcName.'::getInstance();'); 

			return $instance;

		}

	}
}
