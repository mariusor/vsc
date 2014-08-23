<?php
namespace fixtures\application\processors;

use avangate\application\processors\Main;
use avangate\domain\models\RESTModel;
use vsc\presentation\requests\RawHttpRequest;

class FixtureMainProcessor extends Main {

	/**
	 * @param RawHttpRequest $oHttpRequest
	 * @return RESTModel
	 */
	public function getModel(RawHttpRequest $oHttpRequest) {
		return new RESTModel();
	}
}