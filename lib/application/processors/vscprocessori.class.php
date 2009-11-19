<?php
/**
 * @package vsc_application
 * @subpackage processors
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.11.19
 */
interface vscProcessorI {

	/**
	 * @return void
	 */
	public function init ();

	/**
	 * Returns a data model, which can be used in the view
	 * @param vscHttpRequestA $oHttpRequest
	 * @return vscModelI
	 */
	public function handleRequest (vscHttpRequestA $oHttpRequest);
}