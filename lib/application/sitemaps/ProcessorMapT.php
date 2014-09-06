<?php
namespace vsc\application\sitemaps;

use vsc\presentation\helpers\ViewHelperA;
use vsc\presentation\responses\HttpResponseA;
use vsc\presentation\responses\HttpResponseType;

trait ProcessorMapT {
	/**
	 * @var HttpResponseA
	 */
	private $oResponse;

	/**
	 * @var ViewHelperA[]
	 */
	private $aHelpers = array();

	/**
	 * @var int
	 */
	private $iHttpStatus;

	/**
	 * @param HttpResponseA $oResponse
	 */
	public function setResponse (HttpResponseA $oResponse) {
		$this->oResponse = $oResponse;
	}

	/**
	 * @returns HttpResponseA
	 */
	public function getResponse () {
		return $this->oResponse;
	}

	/**
	 * @param ViewHelperA $oHelper
	 * @return void
	 */
	public function registerHelper (ViewHelperA $oHelper) {
		$this->aHelpers[] = $oHelper;
	}

	/**
	 * @returns ViewHelperA[]
	 */
	public function getViewHelpers () {
		return $this->aHelpers;
	}

	/**
	 * @param int $iStatus
	 */
	public function setResponseStatus ($iStatus) {
		if (HttpResponseType::isValidStatus($iStatus)) {
			$this->iHttpStatus = $iStatus;
		}
	}

	/**
	 * @return int
	 */
	public function getResponseStatus () {
		return $this->iHttpStatus;
	}
} 
