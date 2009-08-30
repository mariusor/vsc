<?php
/**
 * @package vsc_controllers
 * @subpackage vsc_requests
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.07.13
 */
abstract class vscHttpRequestA {
	private $sHttpMethod;
	private $sServerProtocol;
	private $aVarOrder;

	private $aGetVars			= array();
	private $aPostVars			= array();
	private $aCookieVars		= array();
	private $aSessionVars		= array();

	private $aAccept			= array();
	private $aAcceptCharset		= array();
	private $aAcceptEncoding	= array();
	private $aAcceptLanguage	= array();

	private $sAuthorization		= '';
	private $iContentLength		= 0; // ? I don't think I'm interested in the length of the request
	private $sContentType		= '';

	private $sIfModifiedSince	= '';
	private $sIfNoneMatch		= '';

	private $sReferer			= '';
	private $sUserAgent			= '';

	public function __construct () {
		$this->aGetVars = $_GET;
		$this->aPostVars = $_POST;
		$this->aCookieVars = $_COOKIE;
//		$this->aSessionVars = $_SESSION;

		if (isset($_SERVER)) {
			$this->getServerProtocol();
			$this->getHttpMethod();
		}

		$this->aAccept			= explode (',', $_SERVER['HTTP_ACCEPT_LANGUAGE']);
		$this->aAcceptLanguage	= explode (',', $_SERVER['HTTP_ACCEPT']);
		$this->aAcceptEncoding	= explode (',', $_SERVER['HTTP_ACCEPT_ENCODING']);
		$this->aAcceptCharset	= explode (',', $_SERVER['HTTP_ACCEPT_CHARSET']);

	}

	/**
	 * @return string
	 */
	public function getServerProtocol () {
		if (!$this->sServerProtocol) {
			$this->sServerProtocol = $_SERVER['SERVER_PROTOCOL'];
		}

		return $this->sServerProtocol;
	}

	public function getVarOrder () {
		if (count($this->aVarOrder) != 4){
			// get gpc order
			$sOrder = ini_get('variables_order');
			for ($i = 0; $i < 4; $i++) {
				// reversing the order
				$this->aVarOrder[$i] = substr($sOrder, $i, 1);
			}
		}
		return $this->aVarOrder;
	}

	public function getVar ($sVarName) {
		foreach ($this->getVarOrder() as $sMethod) {
			try {
				switch ($sMethod) {
					case 'G':
						return $this->getGetVar($sVarName);
						break;
					case 'P':
						return $this->getPostVar($sVarName);
						break;
					case 'C':
						return $this->getCookieVar($sVarName);
						break;
					case 'S':
	//					return $this->getSeesionVar($sVarName);
						break;
				}
			} catch (vscException $e) {
				// no var - go on
			}
		}
		throw new vscException ('Variable ' . $sVarName . ' doesn\'t exist in the http request.');
	}

	protected function getGetVar ($sVarName) {
		if (key_exists($sVarName, $this->aGetVars))
			return $this->aGetVars[$sVarName];
		else throw new vscException ('No GET variable named: ' . $sVarName);
	}

	protected function getPostVar ($sVarName) {
		if (key_exists($sVarName, $this->aPostVars))
			return $this->aPostVars[$sVarName];
		else throw new vscException ('No POST variable named: ' . $sVarName);
	}

	protected function getCookieVar ($sVarName) {
		if (key_exists($sVarName, $this->aCookieVars))
			return $this->aCookieVars[$sVarName];
		else throw new vscException ('No COOKIE variable named: ' . $sVarName);
	}
	public function setCookieVar ($sVarName, $sVarValue) {
		// TODO
	}

	public function getHttpMethod () {
		if (!$this->sHttpMethod) {
			$this->sHttpMethod = $_SERVER['REQUEST_METHOD'];
		}
		return $this->sHttpMethod;
	}

	public function isGet() {
		return ($this->getHttpMethod() == 'GET');
	}

	public function isPost() {
		return ($this->getHttpMethod() == 'POST');
	}

}