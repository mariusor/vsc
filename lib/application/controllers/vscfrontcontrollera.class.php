<?php
/**
 * @package vsc_application
 * @subpackage controllers
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.08.30
 */
abstract class vscFrontControllerA {
	abstract public function getDefaultView ();

	/**
	 * @param vscHttpRequestA $oRequest
	 * @param vscProcessorA $oProcessor
	 * @param vscViewA $oView
	 * @return vscHttpResponseA
	 */
	public function getResponse (vscHttpRequestA $oRequest, $oProcessor = null, $oView = null) {
		import ('presentation/responses');

		if (!($oProcessor instanceof vscErrorProcessorI)) { // this will be allways true
			$oResponse = new vscHttpSuccess();
			$oResponse->setStatus (200);
		} else {
			$oResponse = new vscHttpClientError();
			$oResponse->setStatus($oProcessor->getErrorCode());
		}

		// we didn't set any special view
		if (!$oView) {
			$oView = $this->getDefaultView();
		}

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
}