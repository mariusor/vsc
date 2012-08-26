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

		$iNow = time();
		$iExpireTime = 60; // one minute

		if (vscCacheableViewA::isValid ($this->getView())) {
			$iExpireTime = 604800; // one week
			$iLastModified = strtotime($this->getView()->getModel()->modified);

			$oResponse->setCacheControl ('public, max-age='. $iExpireTime);
			$oResponse->setLastModified(strftime('%a, %d %b %Y %T GMT', $iLastModified));
			$oResponse->setExpires(strftime('%a, %d %b %Y %T GMT', max($iLastModified, $iNow) + $iExpireTime));

			if ( $iLastModified > strtotime($oRequest->getIfModifiedSince()) ) {
				$oResponse->setStatus(304);
			}
		}
		$oResponse->setETag(substr(sha1(serialize($this->getView()->getModel())),0,8));
		if ( $oRequest->getIfNoneMatch() == '"'.$oResponse->getETag().'"' ) {
			$oResponse->setStatus(304);
		}
		return $oResponse;
	}
}