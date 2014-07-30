<?php
/**
 * @package presentation/response
 * @author marius orcsik <marius@habarnam.ro>
 * @date 2013.10.04
 */
namespace vsc\presentation\responses;

class vscRESTResponse extends vscHttpResponseA {
	protected $sContentType = 'application/json';

	public function outputHeaders() {
		d (parent::getContentType());
	}
}
