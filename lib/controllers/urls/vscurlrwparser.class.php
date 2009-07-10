<?php
class vscUrlRWParser extends vscUrlParserA {
	private $sUrl;

	public function __construct () {
		$this->sUrl = $_SERVER['REQUEST_URI'];
	}

	public function getUrl () {
//		d ($this->sUrl);
	}
}