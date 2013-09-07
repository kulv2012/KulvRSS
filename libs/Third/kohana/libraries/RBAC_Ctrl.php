<?php defined('SYSPATH') OR die('No direct access allowed.');

/**
 * RBAC Controller
 *
 * @packaged libraries
 * @author renwenyue@baidu.com
 **/

class RBAC_Ctrl extends Logined_Ctrl {

	protected $session = null;

	public function __construct() {
		parent::__construct();

		$this->accessVerify();

	}

	protected function accessVerify() {

		$this->session = Session::instance();

		// set in loginService
		$cu = $this->session->get('cu');

		if($cu && (!( $cu instanceof User_Object ) || !$cu->verifyUrl(r::getPath())) &&
			(!$cu->isAdmin())
		) {
			$this->show403();
		}

	}

	/*
	 * show 403 page and shutdown
	 */
	protected function show403() {

		$view = new View('skeleton');
		$view->mainContent = new View('rbac/403');
		$view->render(TRUE);
		die();

	}

}
