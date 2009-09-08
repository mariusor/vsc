<?php
/**
 * Parses the current request into a valid Front Controller / Controller pair
 * @package vsc_presentation
 * @subpackage dispatchers
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.08.31
 */
abstract class vscDispatcherA {
	/**
	 * @var vscHttpRequestA
	 */
	private $oRequest;
	/**
	 * @var vscSiteMap
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

	public function getRequest () {
		if (!($this->oRequest instanceof vscHttpRequestA))
			$this->oRequest = vsc::getHttpRequest();
		return $this->oRequest;
	}
}
