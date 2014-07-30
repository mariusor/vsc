<?php
/**
 * @package vsc_presentation
 * @subpackage processors
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.11.18
 */
namespace vsc\application\processors;
// \vsc\import ('domain/models');

use vsc\presentation\requests\vscHttpRequestA;
use vsc\presentation\responses\vscExceptionResponseError;
use vsc\presentation\responses\vscHttpResponse;

class vsc404Processor extends vscErrorProcessor {
	public function __construct () {
		parent::__construct( new vscExceptionResponseError('Not found', 404));
	}

	public function handleRequest(vscHttpRequestA $oHttpRequest) {
		$o404 = new vscHttpResponse();
		$o404->setStatus(404);
		$this->getMap()->setResponse($o404);

		return parent::handleRequest($oHttpRequest);
	}
}