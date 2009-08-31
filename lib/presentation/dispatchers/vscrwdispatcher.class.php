<?php
/**
 * Parses the current request into a valid Front Controller / Controller pair
 * @package vsc_presentation
 * @subpackage dispatchers
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.07.10
 */
class vscRwDispatcher {
	/**
	 * @var vscHttpRequestA
	 */
	private $oRequest;
	/**
	 * @var vscSiteMap
	 */
	private $oSiteMap;

	public function __construct (){
	}

	/**
	 *
	 * @return vscFrontController
	 */
	public function getFrontController () {
		import ('presentation/controllers');
		return new vscHtmlFrontController ();
	}

	public function getProcessController () {
		return new vscEmptyController ();
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
			import ('presentation/sitemaps');
			$this->oSiteMap = new vscSiteMap ();
			$this->oSiteMap->addEntry ('/', $sIncPath);
		}
	}

	public function getRequest () {
		$this->oRequest = vsc::getHttpRequest();
		return $this->oRequest;
	}
}
