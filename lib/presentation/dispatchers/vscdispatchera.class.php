<?php
/**
 * Parses the current request into a valid Front Controller / Controller pair
 * @package vsc_presentation
 * @subpackage dispatchers
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.08.31
 */
import ('presentation/sitemaps');
abstract class vscDispatcherA {
	/**
	 * @var vscHttpRequestA
	 */
	private $oRequest;
	/**
	 * @var vscSiteMapA
	 */
	private $oSiteMap;

	/**
	 * @return vscFrontControllerA
	 */
	abstract public function getFrontController ();

	/**
	 * @return vscProcessorA
	 */
	abstract public function getProcessController ();

	/**
	 *
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
		if ($this->oSiteMap instanceof vscSiteMapA){
			return $this->oSiteMap;
		} else {
			throw new vscExceptionSitemap ('No sitemap loaded.');
		}
	}

	public function getRequest () {
		if (!($this->oRequest instanceof vscHttpRequestA))
			$this->oRequest = vsc::getHttpRequest();
		return $this->oRequest;
	}

}
