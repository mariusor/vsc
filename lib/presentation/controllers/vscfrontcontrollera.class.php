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
	public function getResponse (vscHttpRequestA $oRequest, vscControllerA $oProcessController) {
		import ('presentation/responses');

		if ($oProcessController instanceof vsc404Controller) {
			$oResponse = new vscHttpClientError();
			$oResponse->setStatus(404);
		} else {
			$oResponse = new vscHttpSuccess();
			$oResponse->setStatus (200);

			$oContent = new vscResponseBody();
			$oContent->setOutput($oProcessController->handleRequest($oRequest));

			$oResponse->setContentBody ($oContent);
		}

		return $oResponse;
	}
}