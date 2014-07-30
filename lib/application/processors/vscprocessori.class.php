<?php
/**
 * @package vsc_application
 * @subpackage processors
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.11.19
 */
namespace vsc\application\processors;

use vsc\domain\models\vscModelA;
use vsc\presentation\requests\vscHttpRequestA;
use vsc\presentation\responses\vscHttpResponseA;

interface vscProcessorI {

	/**
	 * @return void
	 */
	public function init ();

	/**
	 * Returns a data model, which can be used in the view
	 * @param vscHttpRequestA $oHttpRequest
	 * @return vscModelA
	 */
	public function handleRequest (vscHttpRequestA $oHttpRequest);


	/**
	 *
	 * @see vscProcessorI::delegateRequest()
	 * @param vscHttpRequestA $oHttpRequest
	 * @param vscProcessorA $oNewProcessor
	 * @param vscHttpResponseA $oResponse
	 * @return vscModelA
	 */
	public function delegateRequest(vscHttpRequestA $oHttpRequest, vscProcessorA $oNewProcessor, vscHttpResponseA $oResponse = null);
}