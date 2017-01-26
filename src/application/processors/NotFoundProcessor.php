<?php
/**
 * @package presentation
 * @subpackage processors
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.11.18
 */
namespace vsc\application\processors;

use vsc\infrastructure\vsc;
use vsc\presentation\requests\HttpRequestA;
use vsc\presentation\responses\ExceptionResponseError;

class NotFoundProcessor extends ErrorProcessor {
	public function __construct() {
		parent::__construct(new ExceptionResponseError('Not found', 404));
	}

	public function handleRequest(HttpRequestA $oHttpRequest) {
		$o404 = vsc::getEnv()->getHttpResponse();
		$o404->setStatus(404);
		$this->getMap()->setResponse($o404);

		return parent::handleRequest($oHttpRequest);
	}
}
