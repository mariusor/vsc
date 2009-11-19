<?php
/**
 * @package vsc_application
 * @subpackage controllers
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.08.30
 */
abstract class vscFrontControllerA {
	/**
	 * @return vscHttpResponseA
	 */
	public function getResponse (vscHttpRequestA $oRequest, $oProcessController = null) {
		import ('presentation/responses');
		import ('presentation/views');

		if (!($oProcessController instanceof vscErrorProcessorI)) { // this will be allways true
			$oResponse = new vscHttpSuccess();
			$oResponse->setStatus (200);
		} else {
			$oResponse = new vscHttpClientError();
			$oResponse->setStatus($oProcessController->getErrorCode());
		}

		$oContent = new vscDefaultView();
		try {
			$oContent->setOutput($oProcessController->handleRequest($oRequest));
		} catch (vscException $e) {
			// something bad in the code
			d ($e);
		} catch (ErrorException $e) {
			// logging theoretically
			_e ($e);
		}

		$oResponse->setContentBody ($oContent);
		return $oResponse;
	}
}