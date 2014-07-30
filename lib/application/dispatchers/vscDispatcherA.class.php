<?php
/**
 * Parses the current request into a valid Front Controller / Controller pair
 * @package vsc_application
 * @subpackage dispatchers
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.08.31
 */
namespace vsc\application\dispatchers;

// \vsc\import ('application/sitemaps');
use vsc\application\controllers\vscFrontControllerA;
use vsc\application\processors\vscProcessorA;
use vsc\application\sitemaps\vscExceptionSitemap;
use vsc\application\sitemaps\vscSiteMapA;
use vsc\infrastructure\vsc;
use vsc\infrastructure\vscObject;
use vsc\presentation\requests\vscHttpRequestA;
use vsc\vscExceptionPath;
use vsc\application\sitemaps\vscControllerMap;
use vsc\application\sitemaps\vscProcessorMap;

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
	 * @var vscProcessorMap
	 */
	protected $oProcessor;

	/**
	 * @var vscControllerMap
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
	 * @throws vscExceptionSitemap
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
			$this->oRequest = vsc::getEnv()->getHttpRequest();
		return $this->oRequest;
	}

}
