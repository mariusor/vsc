<?php
/**
 * @package vsc_presentation
 * @subpackage requests
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
		if (isset($_GET))
			$this->aGetVars		= $_GET;
		if (isset($_POST))
			$this->aPostVars	= $_POST;
		if (isset($_COOKIE))
			$this->aCookieVars	= $_COOKIE;
		if (isset($_SESSION))
			$this->aSessionVars	= $_SESSION;

		if (isset($_SERVER)) {
			$this->getServerProtocol();
			$this->getHttpMethod();

			if (isset ($_SERVER['HTTP_ACCEPT']))
				$this->aAccept			= explode (',', $_SERVER['HTTP_ACCEPT']);
			if (isset ($_SERVER['HTTP_ACCEPT_LANGUAGE']))
				$this->aAcceptLanguage	= explode (',', $_SERVER['HTTP_ACCEPT_LANGUAGE']);
			if (isset ($_SERVER['HTTP_ACCEPT_ENCODING']))
				$this->aAcceptEncoding	= explode (',', $_SERVER['HTTP_ACCEPT_ENCODING']);
			if (isset ($_SERVER['HTTP_ACCEPT_CHARSET']))
				$this->aAcceptCharset	= explode (',', $_SERVER['HTTP_ACCEPT_CHARSET']);

			if (isset ($_SERVER['HTTP_USER_AGENT']))
			$this->sUserAgent		= $_SERVER['HTTP_USER_AGENT'];
			if (isset ($_SERVER['HTTP_REFERER']))
				$this->sReferer			= $_SERVER['HTTP_REFERER'];
		}
	}

	/**
	 * @return string
	 */
	public function getServerProtocol () {
		if (!$this->sServerProtocol && isset ($_SERVER['SERVER_PROTOCOL'])) {
			$this->sServerProtocol = $_SERVER['SERVER_PROTOCOL'];
		}

		return $this->sServerProtocol;
	}

	/**
	 * @return []
	 */
	public function getHttpAccept () {
		return $this->aAccept;
	}

	/**
	 * @return []
	 */
	public function getHttpAcceptCharset () {
		return $this->aAcceptCharset;
	}

	/**
	 * @return []
	 */
	public function getHttpAcceptEncoding () {
		return $this->aAcceptEncoding;
	}

	/**
	 * @return []
	 */
	public function getHttpAcceptLanguage () {
		return $this->aAcceptLanguage;
	}

	/**
	 * @return string
	 */
	public function getHttpReferer () {
		return $this->sReferer;
	}

	/**
	 * @return string
	 */
	public function getHttpUserAgent () {
		return $this->sUserAgent;
	}

	/**
	 * @return []
	 */
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

	/**
	 * @param string $sVarName
	 * @throws vscException
	 * @return mixed
	 */
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
				// no variable - go on with our lives
			}
		}
		throw new vscException ('Variable ' . $sVarName . ' doesn\'t exist in the http request.');
	}

	/**
	 *
	 * @param string $sVarName
	 * @throws vscException
	 * @return mixed
	 */
	protected function getGetVar ($sVarName) {
		if (key_exists($sVarName, $this->aGetVars))
			return $this->aGetVars[$sVarName];
		else throw new vscException ('No GET variable named: ' . $sVarName);
	}

	/**
	 *
	 * @param string $sVarName
	 * @throws vscException
	 * @return mixed
	 */
	protected function getPostVar ($sVarName) {
		if (key_exists($sVarName, $this->aPostVars))
			return $this->aPostVars[$sVarName];
		else throw new vscException ('No POST variable named: ' . $sVarName);
	}

	/**
	 *
	 * @param string $sVarName
	 * @throws vscException
	 * @return mixed
	 */
	protected function getCookieVar ($sVarName) {
		if (key_exists($sVarName, $this->aCookieVars))
			return $this->aCookieVars[$sVarName];
		else throw new vscException ('No COOKIE variable named: ' . $sVarName);
	}

	/**
	 * @param string $sVarName
	 * @param string $sVarValue
	 * @return bool
	 */
	public function setCookieVar ($sVarName, $sVarValue) {
		return setcookie ($sVarName, $sVarValue);
	}

	protected function getHttpMethod () {
		if (!$this->sHttpMethod && isset ($_SERVER['REQUEST_METHOD'])) {
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