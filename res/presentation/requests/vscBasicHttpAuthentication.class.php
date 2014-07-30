<?php
/**
 * @package vsc_presentation
 * @subpackage requests
 * @author marius orcsik <marius@habarnam.ro>
 * @date 2013.09.26
 */
namespace vsc\presentation\requests;

class vscBasicHttpAuthentication extends vscHttpAuthenticationA {
	protected $Type = vscHttpAuthenticationA::BASIC;

	public function __construct($sUserName = null, $sPassword = null) {
		if (!is_null($sUserName)) {
			$this->username = $sUserName;
		}
		if (!is_null($sPassword)) {
			$this->password = $sPassword;
		}
	}
}
