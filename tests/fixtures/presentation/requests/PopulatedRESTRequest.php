<?php
namespace fixtures\presentation\requests;

use vsc\presentation\requests\HttpAuthenticationA;
use vsc\rest\presentation\requests\RESTRequest;

class PopulatedRESTRequest extends RESTRequest {
	protected $aAccept =  array (
		'application/html',
		'text/html;charset=UTF8',
		'image/*'
	);

	public function setAuthentication (HttpAuthenticationA $oHttpAuthentication) {
		parent::setAuthentication($oHttpAuthentication);
	}

	public function setHttpAccept($sAccepts) {
		$this->aAccept = array ($sAccepts);
	}

	/**
	 * @return string[]
	 */
	public function getHttpAccept () {
		return $this->aAccept;
	}

	public function setContentType ($sContentType) {
		$this->sContentType = $sContentType;
	}

	public function constructRawVars ($sRawInput = null) {
		parent::constructRawVars($sRawInput);
	}
}
