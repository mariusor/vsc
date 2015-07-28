<?php
/**
 * @package presentation
 * @subpackage requests
 * @author marius orcsik <marius@habarnam.ro>
 * @date 21.02.15
 */
namespace vsc\presentation\requests;


trait AuthenticatedRequest {
	protected $oAuth;

	/**
	 * @return bool
	 */
	public function hasAuthenticationData() {
		return HttpAuthenticationA::isValid($this->oAuth);
	}

	/**
	 * @returns HttpAuthenticationA
	 */
	public function getAuthentication() {
		return $this->oAuth;
	}

	/**
	 * @param HttpAuthenticationA $oHttpAuthentication
	 */
	protected function setAuthentication(HttpAuthenticationA $oHttpAuthentication) {
		$this->oAuth = $oHttpAuthentication;
	}
}
