<?php
/**
 * @package vsc_presentation
 * @subpackage processors
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.09.09 :)
 * @deprecated
 */
class vscUnitTestProcessor extends vscProcessorA {
	public function init () {
		d ('right here');
	}

	public function handleRequest (vscHttpRequestA $oHttpRequest) {
		return 'unit testing: fuck yeah!';
	}
}