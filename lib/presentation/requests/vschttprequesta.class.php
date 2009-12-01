<?php
/**
 * @package vsc_presentation
 * @subpackage requests
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.07.13
 */
abstract class vscHttpRequestA {
	private $sRequestUri		= null;
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
			$this->sUserAgent			= $_SERVER['HTTP_USER_AGENT'];
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
			switch ($sMethod) {
			case 'G':
				$mVal = $this->getGetVar($sVarName);
				break;
			case 'P':
				$mVal = $this->getPostVar($sVarName);
				break;
			case 'C':
				$mVal = urldecode($this->getCookieVar($sVarName));
				break;
			case 'S':
//				$mVal = $this->getSeesionVar($sVarName);
				break;
			}
			if ($mVal) {
				return $mVal;
			}
		}
		return null;
	}

	/**
	 *
	 * @param string $sVarName
	 * @throws vscException
	 * @return mixed
	 */
	protected function getGetVar ($sVarName) {
		if (key_exists($sVarName, $this->aGetVars)) {
			return $this->aGetVars[$sVarName];
		} else {
			return null;
		}
	}

	/**
	 *
	 * @param string $sVarName
	 * @throws vscException
	 * @return mixed
	 */
	protected function getPostVar ($sVarName) {
		if (key_exists($sVarName, $this->aPostVars)) {
			return $this->aPostVars[$sVarName];
		} else {
			return null;
		}
	}

	/**
	 *
	 * @param string $sVarName
	 * @throws vscException
	 * @return mixed
	 */
	protected function getCookieVar ($sVarName) {
		if (key_exists($sVarName, $this->aCookieVars)) {
			return $this->aCookieVars[$sVarName];
		} else {
			return null;
		}
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


	/**
	 * Returns the REQUEST_URI which is used to get the URL Rewrite variables
	 * This will also remove the part of the path that is actually an existing path
	 * lighttpd:
	 *  url.rewrite = (
	 * 		"^/([^?]*)?(.*)$" => "/index.php$2"
 	 *  )
	 *
	 * @todo move to the vscUrlRWParser
	 * @return string
	 */
	public function getRequestUri ($bUrlDecode = false) {
		if (!$this->sRequestUri && isset($_SERVER['SERVER_SOFTWARE'])) {
			$sServerType = $_SERVER['SERVER_SOFTWARE'];

			// this header is present for all servers in the same form
			$sCurrentScriptDir = dirname ($_SERVER['PHP_SELF']) != '/' ? dirname ($_SERVER['PHP_SELF']) : '';
			if (stristr($sServerType, 'lighttpd')) {
				$sReqUri = $_SERVER['REQUEST_URI'];
				$this->sRequestUri = str_replace ($sCurrentScriptDir, '', $sReqUri);
			} elseif (stristr($sServerType, 'apache')) {
				$sReqUri = $_SERVER['REQUEST_URI'];
				$this->sRequestUri = str_replace ($sCurrentScriptDir, '', $sReqUri);
			} elseif (stristr($sServerType, 'cherokee')) {
				// TODO
			}

			// removing unnecessary get vars
			$iQMarkPos = strpos ($this->sRequestUri, '?');
			if ($iQMarkPos) {
				$this->sRequestUri = substr ($this->sRequestUri, 0, $iQMarkPos);
			}
		}
		if ($bUrlDecode) {
			$this->sRequestUri = urldecode ($this->sRequestUri);
		}

		return $this->sRequestUri;
	}
}