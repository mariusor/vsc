<?php
/**
 * @package vsc_application
 * @subpackage controllers
 * @author marius orcsik <marius@habarnam.ro>
 * @date 2011.02.21
 */
namespace vsc\application\controllers;

// \vsc\import ('infrastructure/caching');
use vsc\domain\models\vscCacheableModelA;
use vsc\infrastructure\caching\vscCacheableI;
use vsc\presentation\requests\vscHttpRequestA;
use vsc\presentation\responses\vscHttpResponseA;
use vsc\presentation\views\vscCacheableViewA;
use vsc\presentation\views\vscExceptionView;
use vsc\application\processors\vscProcessorA;

abstract class vscCacheableControllerA extends vscFrontControllerA implements vscCacheableI {

	public function getLastModified () {
		return false;
	}

	/**
	 * @param vscHttpRequestA $oRequest
	 * @param vscProcessorA $oProcessor
	 * @internal param vscViewA $oView
	 * @return vscHttpResponseA
	 */
	public function getResponse (vscHttpRequestA $oRequest, $oProcessor = null) {
		$oResponse = parent::getResponse($oRequest, $oProcessor);
		
		if ( !($oResponse->isRedirect() || $oResponse->isError()) ) {
			$iNow = time();
			$iExpireTime = 600; // ten minute
			$oNow = new \DateTime('now',  new \DateTimeZone('GMT'));
			$oResponse->setDate($oNow->format('r'));
	
			try {
				$oModel = $this->getView()->getModel();
			} catch (vscExceptionView $v) {
				$oModel = null;
			}
			if ( vscCacheableModelA::isValid ($oModel) ) {
				try {
					/** @var vscCacheableViewA $oView */
					$oView = $this->getView()->getModel();
					$sLastModified = $oView->getLastModified();

					$oLastModified = new \DateTime($sLastModified,  new \DateTimeZone('GMT'));
					$oResponse->setLastModified($oLastModified->format('r'));
					$oMax = $oLastModified->getTimestamp() > $oNow->getTimestamp() ? $oLastModified : $oNow;
	
					$sModifiedSince = $oRequest->getIfModifiedSince();
					if (!empty ($sModifiedSince)) {
						$oModifiedSince =  new \DateTime($sModifiedSince, new \DateTimeZone('GMT'));
	
						if ($oLastModified->getTimestamp() <= $oModifiedSince->getTimestamp()) {
							$oResponse->setStatus(304);
						}
					}
				} catch (\Exception $e) {
					$oMax = $oNow;
				}
				$oResponse->setExpires($oMax->add(new \DateInterval('P2W'))->format('r')); // adding 2 weeks
			} else {
				try {
					$oResponse->setETag( substr(sha1($oResponse->getOutput()), 0, 8) );
					$oResponse->setCacheControl ('public, max-age='. $iExpireTime);
				} catch (vscExceptionView $v) {
					//
				}
	
				if ( $oRequest->getIfNoneMatch() == '"'.$oResponse->getETag().'"' ) {
					$oResponse->setStatus(304);
				}
			}
		}
		return $oResponse;
	}
}