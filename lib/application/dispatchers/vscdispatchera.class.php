<?php
/**
 * Parses the current request into a valid Front Controller / Controller pair
 * @package vsc_application
 * @subpackage dispatchers
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.08.31
 */
import ('application/sitemaps');
abstract class vscDispatcherA extends vscObject {
	/**
	 * @var vscHttpRequestA
	 */
	private $oRequest;
	/**
	 * @var vscSiteMapA
	 */
	private $oSiteMap;

	/**
	 * @var vscProcessorA
	 */
	protected $oProcessor;

	/**
	 * @var vscControllerA
	 */
	protected $oController;

	/**
	 * @return vscFrontControllerA
	 */
	abstract public function getFrontController ();

	/**
	 * @return vscProcessorA
	 */
	abstract public function getProcessController ();


	abstract public function getView ();

	/**
	 * @param string $sIncPath
	 * @throws vscExceptionPath
	 * @return void
	 */
	abstract public function loadSiteMap ($sIncPath);

	/**
	 * @param vscSiteMapA $oSiteMap
	 * @return void
	 */
	public function setSiteMap (vscSiteMapA $oSiteMap) {
		$this->oSiteMap = $oSiteMap;
	}

	/**
	 * @return vscSiteMapA
	 */
	public function getSiteMap () {
		if (vscSiteMapA::isValid($this->oSiteMap )){
			return $this->oSiteMap;
		} else {
			throw new vscExceptionSitemap ('No sitemap loaded.');
		}
	}

	/**
	 * @return vscHttpRequestA
	 */
	public function getRequest () {
		if (!vscHttpRequestA::isValid($this->oRequest))
			$this->oRequest = vsc::getHttpRequest();
		return $this->oRequest;
	}

}
