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
		$iExpireTime = 600; // ten minute
		$oNow = new DateTime('now',  new DateTimeZone('GMT'));
		$oResponse->setDate($oNow->format('r'));

		if (vscCacheableModelA::isValid ($this->getView()->getModel())) {
			$sLastModified = $this->getView()->getModel()->getLastModified();
			if (!empty ($sLastModified)) {
				$oLastModified = new DateTime($sLastModified,  new DateTimeZone('GMT'));
				$oResponse->setLastModified($oLastModified->format('r'));
				$oMax = $oLastModified->getTimestamp() > $oNow->getTimestamp() ? $oLastModified : $oNow;

				$sModifiedSince = $oRequest->getIfModifiedSince();
				if (!empty ($sModifiedSince)) {
					$oModifiedSince =  new DateTime($sModifiedSince, new DateTimeZone('GMT'));

					//$this->getView()->getModel()->content = $oLastModified->getTimestamp() . ' = ' . $oModifiedSince->getTimestamp();
					if ($oLastModified->getTimestamp() <= $oModifiedSince->getTimestamp()) {
						$oResponse->setStatus(304);
					}
				}
			} else {
				$oMax = $oNow;
			}
			$oResponse->setExpires($oMax->add(new DateInterval('P2W'))->format('r')); // adding 2 weeks
		} else {
			$oResponse->setETag( substr(sha1(serialize($this->getView()->getModel())),0,8) );
			$oResponse->setCacheControl ('public, max-age='. $iExpireTime);

			if ( $oRequest->getIfNoneMatch() == '"'.$oResponse->getETag().'"' ) {
				$oResponse->setStatus(304);
			}
		}

		return $oResponse;
	}
}