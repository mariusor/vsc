<?php
/**
 * Parses the current request into a valid Front Controller / Controller pair
 * @package application
 * @subpackage dispatchers
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.08.31
 */
namespace vsc\application\dispatchers;

use vsc\application\controllers\FrontControllerA;
use vsc\application\processors\ProcessorA;
use vsc\application\sitemaps\ExceptionSitemap;
use vsc\application\sitemaps\RwSiteMap;
use vsc\application\sitemaps\SiteMapA;
use vsc\infrastructure\vsc;
use vsc\infrastructure\Object;
use vsc\presentation\requests\HttpRequestA;
use vsc\ExceptionPath;

abstract class DispatcherA extends Object {
	/**
	 * @var HttpRequestA
	 */
	private $oRequest;
	/**
	 * @var SiteMapA
	 */
	private $oSiteMap;

	/**
	 * @var ProcessorA
	 */
	protected $oProcessor;

	/**
	 * @var FrontControllerA
	 */
	protected $oController;

	/**
	 * @returns FrontControllerA
	 */
	abstract public function getFrontController();

	/**
	 * @returns ProcessorA
	 */
	abstract public function getProcessController();

	abstract public function getView();

	/**
	 * @param string $sIncPath
	 * @throws ExceptionPath
	 * @return void
	 */
	abstract public function loadSiteMap($sIncPath);

	/**
	 * @param SiteMapA $oSiteMap
	 * @return void
	 */
	public function setSiteMap(SiteMapA $oSiteMap) {
		$this->oSiteMap = $oSiteMap;
	}

	/**
	 * @throws ExceptionSitemap
	 * @returns SiteMapA
	 */
	public function getSiteMap() {
		if (!SiteMapA::isValid($this->oSiteMap)) {
			$this->oSiteMap = new RwSiteMap();
		}
		return $this->oSiteMap;
	}

	/**
	 * @returns HttpRequestA
	 */
	public function getRequest() {
		if (!HttpRequestA::isValid($this->oRequest)) {
			$this->oRequest = vsc::getEnv()->getHttpRequest();
		}
		return $this->oRequest;
	}

}
