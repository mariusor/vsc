<?php
namespace _fixtures\presentation\requests;

use vsc\rest\presentation\requests\RESTRequest;

class PopulatedRESTRequest extends RESTRequest {

	public function setContentType ($sContentType) {
		$this->sContentType = $sContentType;
	}
} 
