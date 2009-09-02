<?php
/**
 * @package vsc_presentation
 * @subpackage controllers
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.08.31
 */
class vscHtmlFrontController extends vscFrontControllerA {
	public function getResponse (vscControllerA $oProcessController) {
		import ('presentation/responses');

		if ($oProcessController instanceof vsc404Controller) {
			$oResponse = new vscHttpClientError();
			$oResponse->setStatus(404);
		} else {
			$oResponse = new vscHttpSuccess();
			$oResponse->setStatus (200);
		}

		return $oResponse;
	}
}