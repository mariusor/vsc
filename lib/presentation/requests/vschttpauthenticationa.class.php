<?php
abstract class vscHttpAuthenticationA extends vscObject {
	const DIGEST = 'Digest';
	const BASIC = 'Basic';

	private $sType = self::BASIC;

	private $sUser;
	private $sPassword;

	public function setType($sType) {
		$this->sType = $sType;
	}
	public function getType() {
		return $this->sType;
	}
	public function setUser($sUser) {
		$this->sUser = $sUser;
	}
	public function getUser() {
		return $this->sUser;
	}
	public function setPassword($sPassword) {
		$this->sPassword = $sPassword;
	}
	public function getPassword() {
		return $this->sPassword;
	}
}