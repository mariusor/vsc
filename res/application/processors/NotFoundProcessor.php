<?php
/**
 * @package presentation
 * @subpackage processors
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.11.18
 */
namespace vsc\application\processors;

use vsc\presentation\requests\HttpRequestA;
use vsc\presentation\responses\ExceptionResponseError;
use vsc\presentation\responses\HttpResponse;

class NotFoundProcessor extends ErrorProcessor {
	public function __construct () {
		parent::__construct( new ExceptionResponseError('Not found', 404));
	}

	public function handleRequest(HttpRequestA $oHttpRequest) {
		$o404 = new HttpResponse();
		$o404->setStatus(404);
		$this->getMap()->setResponse($o404);

		return parent::handleRequest($oHttpRequest);
	}
}
