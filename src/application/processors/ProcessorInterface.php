<?php
/**
 * @package application
 * @subpackage processors
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.11.19
 */
namespace vsc\application\processors;

use vsc\domain\models\ModelA;
use vsc\presentation\requests\HttpRequestA;
use vsc\presentation\responses\HttpResponseA;

interface ProcessorInterface {

	/**
	 * @return void
	 */
	public function init();

	/**
	 * Returns a data model, which can be used in the view
	 * @param HttpRequestA $oHttpRequest
	 * @returns ModelA
	 */
	public function handleRequest(HttpRequestA $oHttpRequest);


	/**
	 * Redirects the current request to a different processor
	 * @param HttpRequestA $oHttpRequest
	 * @param ProcessorA $oNewProcessor
	 * @param HttpResponseA $oResponse
	 * @returns ModelA
	 */
	public function delegateRequest(HttpRequestA $oHttpRequest, ProcessorA $oNewProcessor, HttpResponseA $oResponse = null);
}
