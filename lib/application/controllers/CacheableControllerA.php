<?php
/**
 * @package application
 * @subpackage controllers
 * @author marius orcsik <marius@habarnam.ro>
 * @date 2011.02.21
 */
namespace vsc\application\controllers;

use vsc\domain\models\CacheableModelA;
use vsc\domain\models\ModelA;
use vsc\infrastructure\caching\CacheableI;
use vsc\presentation\requests\HttpRequestA;
use vsc\presentation\responses\HttpResponseA;
use vsc\presentation\responses\HttpResponseType;
use vsc\presentation\views\ExceptionView;
use vsc\application\processors\ProcessorA;

abstract class CacheableControllerA extends FrontControllerA implements CacheableI {

	public function getLastModified() {
		return false;
	}

	/**
	 * @param HttpRequestA $oRequest
	 * @param ModelA $oModel
	 * @param HttpResponseA $oResponse
	 * @return HttpResponseA
	 */
	public function addCacheHeaders (HttpRequestA $oRequest, ModelA $oModel, HttpResponseA $oResponse) {
		$iExpireTime = 600; // ten minute
		$oNow = new \DateTime('now', new \DateTimeZone('GMT'));
		$oResponse->setDate($oNow->format('r'));
		if (CacheableModelA::isValid($oModel)) {
			try {
				/** @var CacheableModelA $oModel */
				$sLastModified = $oModel->getLastModified();

				$oLastModified = new \DateTime($sLastModified, new \DateTimeZone('GMT'));
				$oResponse->setLastModified($oLastModified->format('r'));
				$oMax = $oLastModified->getTimestamp() > $oNow->getTimestamp() ? $oLastModified : $oNow;

				$sModifiedSince = $oRequest->getIfModifiedSince();
				if (!empty ($sModifiedSince)) {
					$oModifiedSince = new \DateTime($sModifiedSince, new \DateTimeZone('GMT'));

					if ($oLastModified->getTimestamp() <= $oModifiedSince->getTimestamp()) {
						$oResponse->setStatus(HttpResponseType::NOT_MODIFIED);
					}
				}
			} catch (\Exception $e) {
				$oMax = $oNow;
			}
			$oResponse->setExpires($oMax->add(new \DateInterval('P2W'))->format('r')); // adding 2 weeks
		} else {
			try {
				$oResponse->setETag(substr(sha1($oResponse->getOutput()), 0, 8));
				$oResponse->setCacheControl('public, max-age=' . $iExpireTime);
			} catch (ExceptionView $v) {
				//
			}

			if (trim($oRequest->getIfNoneMatch(), '"') == trim($oResponse->getETag(), '"')) {
				$oResponse->setStatus(HttpResponseType::NOT_MODIFIED);
			}
		}
		return $oResponse;
	}

	/**
	 * @param HttpRequestA $oRequest
	 * @param ProcessorA $oProcessor
	 * @returns HttpResponseA
	 */
	public function getResponse(HttpRequestA $oRequest, $oProcessor = null) {
		$oResponse = parent::getResponse($oRequest, $oProcessor);

		if (!($oResponse->isRedirect() || $oResponse->isError())) {
			$this->addCacheHeaders($oRequest, $this->getView()->getModel(), $oResponse);
		}

		return $oResponse;
	}
}
