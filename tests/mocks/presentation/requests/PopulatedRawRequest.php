<?php
namespace mocks\presentation\requests;


use vsc\presentation\requests\RawHttpRequest;

class PopulatedRawRequest extends RawHttpRequest {
//	protected $sContentType = 'application/json';

	public function setContentType ($sContentType) {
		$this->sContentType = $sContentType;
	}

	public function constructRawVars ($sRawInput = null) {
		parent::constructRawVars($sRawInput);
	}
} 
