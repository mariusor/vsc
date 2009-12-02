<?php
/**
 * @package vsc_application
 * @subpackage controllers
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.08.30
 */
import ('presentation/responses');
abstract class vscFrontControllerA {
	private $oCurrentMap;

	/**
	 * @return vscViewA
	 */
	abstract public function getDefaultView();

	/**
	 * @return vscMapping
	 */
	public function getMap () {
		if ($this->oCurrentMap instanceof vscMapping) {
			return $this->oCurrentMap;
		} else {
			throw new vscExceptionView ('Make sure the current map is correctly set.');
		}
	}

	public function setMap ($oMap) {
		$this->oCurrentMap = $oMap;
	}

	/**
	 * @param vscHttpRequestA $oRequest
	 * @param vscProcessorA $oProcessor
	 * @param vscViewA $oView
	 * @return vscHttpResponseA
	 */
	public function getResponse (vscHttpRequestA $oRequest, $oProcessor = null) {

		if (!($oProcessor instanceof vscErrorProcessorI)) {
			$oResponse = new vscHttpSuccess();
			$oResponse->setStatus (200);
		} else {
			$oResponse = new vscHttpClientError();
			$oResponse->setStatus($oProcessor->getErrorCode());
		}

		// we didn't set any special view
		// this means that the developer needs to provide his own views
		$oView = $this->getDefaultView();
		try {
			$oMyMap = $this->getMap();
		} catch (Exception $e) {
			// no map
			$oMyMap = null;
		}
		try {
			$oMap = $oProcessor->getMap()->merge ($oMyMap);
			$oView->setMap ($oMap);
		} catch (vscException $e) {
			// no map
		}

		try {
			$oModel = $oProcessor->handleRequest($oRequest);
			if ($oModel instanceof vscModelA) {
				$oView->setModel($oModel);
			}
		} catch (Exception $e) {
			throw $e;
		}

		$oResponse->setContentBody ($oView);
		return $oResponse;
	}

	public function setTemplatePath ($sIncPath) {
		if (is_dir($sIncPath)) {
			$this->sTemplatePath = $sIncPath;
		} else {
			throw new vscExceptionController('The template path ['.$sIncPath.'] is not a folder.');
		}
	}
}