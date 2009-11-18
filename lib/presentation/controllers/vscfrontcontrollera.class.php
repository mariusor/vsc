<?php
/**
 * @package vsc_presentation
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

		if (!($oProcessController instanceof vscErrorProcessorI)) { // this will be allways true
			$oResponse = new vscHttpSuccess();
			$oResponse->setStatus (200);
		} else {
			$oResponse = new vscHttpClientError();
			$oResponse->setStatus($oProcessController->getErrorCode());
		}

		$oContent = new vscResponseBody();
		$oContent->setOutput($oProcessController->handleRequest($oRequest));

		$oResponse->setContentBody ($oContent);
		return $oResponse;
	}
}