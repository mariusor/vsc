<?php
/**
 * @package vsc_application
 * @subpackage controllers
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.08.30
 */
import ('presentation/responses');

abstract class vscFrontControllerA {
	private $sTemplatePath;
	private $sMainTemplatePath;

	/**
	 * @return vscViewA
	 */
	abstract public function getDefaultView();

	public function getTemplatePath () {
		return $this->sTemplatePath;
	}

	public function setTemplate ($sPath) {
		$this->sMainTemplatePath = $sPath;
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
		$oView->setTemplate($this->sMainTemplatePath);

		try {
			$oView->setModel($oProcessor->handleRequest($oRequest));
		} catch (vscException $e) {
			// something bad in the code
			d ($e);
		} catch (ErrorException $e) {
			// logging theoretically
			_e ($e);
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