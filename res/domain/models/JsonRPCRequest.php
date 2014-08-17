<?php
/**
 * @package domain
 * @subpackage models
 * @author marius orcsik <marius@habarnam.ro>
 * @date 2012.08.25
 */
namespace vsc\domain\models;

use vsc\infrastructure\vsc;
use vsc\presentation\requests\RawHttpRequest;

class JsonRPCRequest extends ModelA {
	public $id = null;
	public $method = '';
	public $params = array();

	public function __construct ($oRequest = null) {
		/* @var RawHttpRequest $oRequest */

		if (RawHttpRequest::isValid($oRequest)) {
			$oRequest = vsc::getEnv()->getHttpRequest();
		}

		$this->id		= $oRequest->getVar ('id');
		$this->method	= $oRequest->getVar ('method');
		$this->params	= $oRequest->getVar ('params');
	}
}
