<?php
/**
 * @package vsc_application
 * @subpackage controllers
 * @author marius orcsik <marius@habarnam.ro>
 * @date 2011.02.21
 */
abstract class vscCacheableControllerA extends vscFrontControllerA {

	/**
	 * @param vscHttpRequestA $oRequest
	 * @param vscProcessorA $oProcessor
	 * @param vscViewA $oView
	 * @return vscHttpResponseA
	 */
	public function getResponse (vscHttpRequestA $oRequest, $oProcessor = null) {
		$oResponse = parent::getResponse($oRequest, $oProcessor);

		if ($oResponse->getStatus() >= 300) {
			return $oResponse;
		}

		$aModel = $oResponse->getView()->getModel()->toArray();
		$oResponse->setETag( md5 ( serialize($aModel) ) );

		$iExpireTime = 86400;
		$iNow = time();

		// checking if the resource has not been modified so the user agent can serve from cache
		if ($oRequest->getIfNoneMatch() == '"' . $oResponse->getETag() . '"') {
			$oResponse->setStatus(304);
			$oResponse->setContentLength(0);
		}

		if (vscCacheableViewA::isValid($this->getView())) {
			// if the last modified date + max-age is lower than the current date we need to extend it with one more day
			if ($iNow > $iExpireTime + $this->getView()->getMTime()) {
				$iExpireTime += ($iNow - $this->getView()->getMTime());
			}
		} else {
			$iExpireTime += $iNow;
		}

		$oResponse->setCacheControl ('max-age='. $iExpireTime . ', must-revalidate');

		return $oResponse;
	}
}