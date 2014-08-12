<?php
/**
 * @package application
 * @subpackage controllers
 * @author marius orcsik <marius@habarnam.ro>
 * @date 2011.02.21
 */
namespace vsc\application\controllers;

use vsc\domain\models\CacheableModelA;
use vsc\infrastructure\caching\CacheableI;
use vsc\presentation\requests\HttpRequestA;
use vsc\presentation\responses\HttpResponseA;
use vsc\presentation\views\CacheableViewA;
use vsc\presentation\views\ExceptionView;
use vsc\application\processors\ProcessorA;

abstract class CacheableControllerA extends FrontControllerA implements CacheableI {

	public function getLastModified () {
		return false;
	}

	/**
	 * @param HttpRequestA $oRequest
	 * @param ProcessorA $oProcessor
	 * @returns HttpResponseA
	 */
	public function getResponse (HttpRequestA $oRequest, $oProcessor = null) {
		$oResponse = parent::getResponse($oRequest, $oProcessor);

		if ( !($oResponse->isRedirect() || $oResponse->isError()) ) {
			$iNow = time();
			$iExpireTime = 600; // ten minute
			$oNow = new \DateTime('now',  new \DateTimeZone('GMT'));
			$oResponse->setDate($oNow->format('r'));

			try {
				$oModel = $this->getView()->getModel();
			} catch (ExceptionView $v) {
				$oModel = null;
			}
			if ( CacheableModelA::isValid ($oModel) ) {
				try {
					/** @var CacheableViewA $oView */
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
				} catch (ExceptionView $v) {
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
