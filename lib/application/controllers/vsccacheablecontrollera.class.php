<?php
/**
 * @package vsc_application
 * @subpackage controllers
 * @author marius orcsik <marius@habarnam.ro>
 * @date 2011.02.21
 */

import ('infrastructure/caching');
abstract class vscCacheableControllerA extends vscFrontControllerA implements vscCacheableI {

	public function getLastModified () {
		return false;
	}

	/**
	 * @param vscHttpRequestA $oRequest
	 * @param vscProcessorA $oProcessor
	 * @param vscViewA $oView
	 * @return vscHttpResponseA
	 */
	public function getResponse (vscHttpRequestA $oRequest, $oProcessor = null) {
		$oResponse = parent::getResponse($oRequest, $oProcessor);

		if ( !($oResponse->isRedirect() || $oResponse->isError()) ) {
			$iNow = time();
			$iExpireTime = 600; // ten minute
			$oNow = new DateTime('now',  new DateTimeZone('GMT'));
			$oResponse->setDate($oNow->format('r'));

			$oModel = $this->getView()->getModel();
			if ( vscCacheableModelA::isValid ($oModel) ) {
				$sLastModified = $this->getView()->getModel()->getLastModified();
				try {
					$oLastModified = new DateTime($sLastModified,  new DateTimeZone('GMT'));
					$oResponse->setLastModified($oLastModified->format('r'));
					$oMax = $oLastModified->getTimestamp() > $oNow->getTimestamp() ? $oLastModified : $oNow;

					$sModifiedSince = $oRequest->getIfModifiedSince();
					if (!empty ($sModifiedSince)) {
						$oModifiedSince =  new DateTime($sModifiedSince, new DateTimeZone('GMT'));

						if ($oLastModified->getTimestamp() <= $oModifiedSince->getTimestamp()) {
							$oResponse->setStatus(304);
						}
					}
				} catch (Exception $e) {
					$oMax = $oNow;
				}
				$oResponse->setExpires($oMax->add(new DateInterval('P2W'))->format('r')); // adding 2 weeks
			} else {
				$oResponse->setETag( substr(sha1($oResponse->getOutput()), 0, 8) );
				$oResponse->setCacheControl ('public, max-age='. $iExpireTime);

				if ( $oRequest->getIfNoneMatch() == '"'.$oResponse->getETag().'"' ) {
					$oResponse->setStatus(304);
				}
			}
		}
		return $oResponse;
	}
}