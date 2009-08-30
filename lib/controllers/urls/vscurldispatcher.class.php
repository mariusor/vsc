<?php
/**
 * Parses the current request into a valid Front Controller / Controller pair
 * @package vsc_controller
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.07.10
 */
class vscUrlDispatcher {
	/**
	 *
	 * @var vscHttpRequestA
	 */
	private $oRequest;
	/**
	 * @var vscSiteMap
	 */
	private $oSiteMap;

	public function __construct (){}

	/**
	 *
	 * @return vscFrontController
	 */
	public function getFrontController () {
		import ('controllers/controllers');
		return new vscFrontController();
	}

	public function getProcessController () {
		return new tsMainController();
	}

	/**
	 *
	 * @param string $sIncPath
	 * @throws vscExceptionPath
	 * @return void
	 */
	public function loadSiteMap ($sIncPath) {
		if (!is_file ($sIncPath)) {
			throw new vscExceptionPath('[' . $sIncPath . '] is not a valid path.');
		} else {
			import ('controllers/sitemaps');
			$this->oSiteMap = new vscSiteMap ();
			$this->oSiteMap->addMap ('/', $sIncPath);
		}
	}

	public function getRequest () {}


}
