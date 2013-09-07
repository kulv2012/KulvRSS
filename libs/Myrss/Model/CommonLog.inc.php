<?php
//简单的日志库，本身是从baidu的mc_log.inc.php修改而来

final class __mc_log
{
	const LOG_FATAL   = 1;
	const LOG_WARNING = 2;
	const LOG_MONITOR = 3;
	const LOG_NOTICE  = 4;
	const LOG_TRACE   = 8;
	const LOG_DEBUG   = 16;
	const PAGE_SIZE   = 4096;
	const LOG_SPACE   = "\10";
	const MONTIR_STR  = ' ---MONITOR---';

	static $LOG_NAME = array (
			self::LOG_FATAL   => 'FATAL',
			self::LOG_WARNING => 'WARNING',
			self::LOG_MONITOR => 'MONITOR',
			self::LOG_NOTICE  => 'NOTICE',
			self::LOG_TRACE   => 'TRACE',
			self::LOG_DEBUG   => 'DEBUG'
			);
	static $BASIC_FIELD = array (
			'logid',
			'reqip',
			'uid',
			'uname',
			'method',
			'uri'
			);

	private $log_name   = '';
	private $log_path   = '';
	private $wflog_path = '';
	private $log_str    = '';
	private $wflog_str  = '';
	private $basic_info = '';
	private $notice_str = '';
	private $log_level	= 16;
	private $arr_basic  = null;

	private $force_flush = false;

	private $init_pid   = 0;

	function __construct()
	{
	}

	function __destruct()
	{
		if ($this->init_pid==posix_getpid()) {
			$this->check_flush_log(true);
		}
	}

	function init($dir, $name, $level, $arr_basic_info, $flush=false)
	{
		if (empty($dir) || empty($name)) {
			return false;
		}

		if ('/'!= $dir{0}) {
			$dir = realpath($dir);
		}

		$dir  = rtrim($dir, ".");
		$name = rtrim($name, "/");
		$this->log_path   = $dir . "/" . $name .".log";
		$this->wflog_path = $dir . "/" . $name . ".log.wf";	
		$this->log_name  = $name;
		$this->log_level = $level;

		$this->arr_basic = $arr_basic_info;
		$this->gen_basicinfo();
		$this->init_pid = posix_getpid();
		$this->force_flush = $flush;
		
		return true;
	}

	private function gen_log_part($str)
	{
		return "[ " . self::LOG_SPACE . $str . " ". self::LOG_SPACE . "]";
	}

	private function gen_basicinfo()
	{
		$this->basic_info = '';
		foreach (self::$BASIC_FIELD as $key) {
			if (!empty($this->arr_basic[$key])) {
				$this->basic_info .= $this->gen_log_part("$key:".$this->arr_basic[$key]) . " ";
			}
		}
	}

	private function check_flush_log($force_flush)
	{
		if (strlen($this->log_str)>self::PAGE_SIZE || strlen($this->wflog_str)>self::PAGE_SIZE ) {
			$force_flush = true;
		}	

		if ($force_flush) {
			/* first write warning log */
			if (!empty($this->wflog_str)) {
				$this->write_file($this->wflog_path, $this->wflog_str);
			}
			/* then common log */
			if (!empty($this->log_str)) {
				$this->write_file($this->log_path, $this->log_str);
			}

			/* clear the printed log*/
			$this->wflog_str = '';
			$this->log_str   = '';
		
		} /* force_flush */
	}

	
	private function write_file($path, $str)
	{
		$fd = @fopen($path, "a+" );
		if (is_resource($fd)) {
			fputs($fd, $str);
			fclose($fd);
		}
		return;
	}

	public function add_basicinfo($arr_basic_info)
	{
		$this->arr_basic = array_merge($this->arr_basic, $arr_basic_info);
		$this->gen_basicinfo();
	}

	public function push_notice($format, $arr_data)
	{
		$this->notice_str .= " " .$this->gen_log_part(vsprintf($format, $arr_data));
	}

	public function clear_notice()
	{
		$this->notice_str = '';
	}

	public function write_log($type, $format, $arr_data)
	{
		if ($this->log_level<$type)
			return;

		/* log heading */
		$str = sprintf( "%s: %s: %s * %d", self::$LOG_NAME[$type], date("m-d H:i:s"),
				$this->log_name, posix_getpid() );
		/* add monitor tag?	*/	
		if ($type==self::LOG_MONITOR || $type==self::LOG_FATAL) {
			$str .= self::MONTIR_STR;
		}
		/* add basic log */
		$str .= " " . $this->basic_info;
		/* add detail log */
		$str .= " " . vsprintf($format, $arr_data);

		switch ($type) {
			case self::LOG_MONITOR :
			case self::LOG_FATAL :
			case self::LOG_WARNING :
			case self::LOG_FATAL :
				$this->wflog_str .= $str . "\n";
				break;
			case self::LOG_DEBUG :
			case self::LOG_TRACE :
				$this->log_str .= $str . "\n";
				break;
			case self::LOG_NOTICE : 	
				$this->log_str .= $str . $this->notice_str . "\n";
				$this->clear_notice();
				break;
			default : 
				break;	
		}

		$this->check_flush_log($this->force_flush); 
	}
}


$__log = null;

function __log($type, $arr)
{
	global $__log;
	$format = $arr[0];
	array_shift($arr);

	$pid = posix_getpid();

	if (!empty($__log[$pid])) {
		$log = $__log[$pid];
		$log->write_log($type, $format, $arr);
	} else {
		$s =  __mc_log::$LOG_NAME[$type] . ' ' . vsprintf($format, $arr) . "\n";
		echo $s;
	} /* if $__log */
}

function log_init($dir, $file, $level, $info, $flush=false)
{
	global $__log;

	$pid = posix_getpid();

	if (!empty($__log[$pid]) ) {
		unset($__log[$pid]);
	}

	$__log[posix_getpid()] = new __mc_log(); 
	$log = $__log[posix_getpid()];
	if ($log->init($dir, $file, $level, $info, $flush)) {
		return true;
	} else {
		unset($__log[$pid]);
		return false;
	}
}


function LOG_DEBUG()
{
	$arg = func_get_args();
	__log(__mc_log::LOG_DEBUG, $arg );
}


function LOG_TRACE()
{
	$arg = func_get_args();
	__log(__mc_log::LOG_TRACE, $arg );
}


function LOG_NOTICE()
{
	$arg = func_get_args();
	__log(__mc_log::LOG_NOTICE, $arg );
}


function LOG_MONITOR()
{
	$arg = func_get_args();
	__log(__mc_log::LOG_MONITOR, $arg );
}

function LOG_WARNING()
{
	$arg = func_get_args();
	__log(__mc_log::LOG_WARNING, $arg );
}


function LOG_FATAL()
{
	$arg = func_get_args();
	__log(__mc_log::LOG_FATAL, $arg );
}


function log_pushnotice()
{
	global $__log;
	$arr = func_get_args();

	$pid = posix_getpid();

	if (!empty($__log[$pid])) {
		$log = $__log[$pid];
		$format = $arr[0];
		/* shift $type and $format, arr_data left */
		array_shift($arr);
		$log->push_notice($format, $arr);
	} else {
		/* nothing to do */
	}
}

function log_clearnotice()
{
	global $__log;
	$arr = func_get_args();

	$pid = posix_getpid();

	if (!empty($__log[$pid])) {
		$log = $__log[$pid];
		$log->clear_notice();
	} else {
		/* nothing to do */
	}
}


function log_addbasic($arr_basic)
{
	global $__log;
	$arr = func_get_args();

	$pid = posix_getpid();

	if (!empty($__log[$pid])) {
		$log = $__log[$pid];
		$log->add_basicinfo($arr_basic);
	} else {
		/* nothing to do */
	}
}



/* vim: set ts=4 sw=4 sts=4 tw=100 noet: */
?>
