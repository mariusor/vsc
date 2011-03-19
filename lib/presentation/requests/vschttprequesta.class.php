<?php
/**
 * @package vsc_presentation
 * @subpackage requests
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.07.13
 */

import ('infrastructure/urls');

class vscHttpRequestTypes {
	const GET		= 'GET';
	const HEAD		= 'HEAD';
	const POST		= 'POST';
	const PUT		= 'PUT';
	const DELETE	= 'DELETE';
}

abstract class vscHttpRequestA extends vscObject {
	private $sUri		= null;
	private $oUri;
	private $sHttpMethod;
	private $sServerName;
	private $sServerProtocol;
	private $aVarOrder;

	private $aGetVars			= array();
	private $aPostVars			= array();
	private $aCookieVars		= array();
	private $aSessionVars		= array();
	private $aFiles				= array();

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

		if (count ($_FILES) >= 1 ) {
			$this->aFiles = $_FILES;
		}

		if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE'])) {
			$this->sIfModifiedSince = $_SERVER['HTTP_IF_MODIFIED_SINCE'];
		}

		if (isset($_SERVER['HTTP_IF_NONE_MATCH'])) {
			$this->sIfNoneMatch = $_SERVER['HTTP_IF_NONE_MATCH'];
		}
	}

	public function hasFiles () {
		return (is_array($this->aFiles) && count ($this->aFiles) >=1 );
	}

	public function getFiles() {
		return $this->aFiles;
	}

	public function getFile ($sFileName) {
	}

	public function getServerName() {
		if (!$this->sServerName && isset ($_SERVER['SERVER_NAME'])) {
			$this->sServerName = $_SERVER['SERVER_NAME'];
		}

		return $this->sServerName;
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
	public function getIfModifiedSince () {
		return $this->sIfModifiedSince;
	}

	/**
	 * @return string
	 */
	public function getIfNoneMatch () {
		return $this->sIfNoneMatch;
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

    public function getGetVars() {
        return $this->aGetVars;
    }

    public function getPostVars() {
        return $this->aPostVars;
    }

    public function getCookieVars() {
        return $this->aCookieVars;
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

	public function getVars () {
		$aRet = array ();
		foreach ($this->getVarOrder() as $sMethod) {
			switch ($sMethod) {
			case 'G':
				$aRet = array_merge ($aRet, $this->aGetVars);
				break;
			case 'P':
				$aRet = array_merge ($aRet, $this->aPostVars);
				break;
			case 'C':
				$aRet = array_merge ($aRet, $this->aCookieVars);
				break;
			case 'S':
				$aRet = array_merge ($aRet, $this->aSessionVars);
				break;
			}
		}
		return $aRet;
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

	public function getHttpMethod () {
		if (!$this->sHttpMethod && isset ($_SERVER['REQUEST_METHOD'])) {
			$this->sHttpMethod = $_SERVER['REQUEST_METHOD'];
		}
		return $this->sHttpMethod;
	}

	/**
	 * @return bool
	 */
	public function isGet() {
		return ($this->getHttpMethod() == vscHttpRequestTypes::GET);
	}

	/**
	 * @return bool
	 */
	public function isHead() {
		return ($this->getHttpMethod() == vscHttpRequestTypes::HEAD);
	}

	/**
	 * @return bool
	 */
	public function isPost() {
		return ($this->getHttpMethod() == vscHttpRequestTypes::POST);
	}

	/**
	 * @return bool
	 */
	public function isPut() {
		return ($this->getHttpMethod() == vscHttpRequestTypes::PUT);
	}

	/**
	 * @return bool
	 */
	public function isDelete() {
		return ($this->getHttpMethod() == vscHttpRequestTypes::DELETE);
	}

	/**
	 * @return bool
	 */
	public function isSecure () {
		return (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on');
	}

	/**
	 * Returns the REQUEST_URI which is used to get the URL Rewrite variables
	 * This will also remove the part of the path that is actually an existing path
	 * lighttpd:
	 *  url.rewrite = (
	 * 		"^/([^?]*)?(.*)$" => "/index.php$2" <- this doesn't look right to me
 	 *  )
	 *
	 * @todo move to the vscUrlRWParser
	 * @return string
	 */
	public function getUri ($bUrlDecode = false) {
		if (!$this->sUri && isset($_SERVER['SERVER_SOFTWARE'])) {
			$sServerType = $_SERVER['SERVER_SOFTWARE'];

			// this header is present for all servers in the same form
			$sCurrentScriptDir = dirname ($_SERVER['PHP_SELF']) != '/' ? dirname ($_SERVER['PHP_SELF']) : '';
			if (stristr($sServerType, 'lighttpd')) {
				$sReqUri = $_SERVER['REQUEST_URI'];
				$this->sUri = str_replace ($sCurrentScriptDir, '', $sReqUri);
			} elseif (stristr($sServerType, 'apache')) {
				$sReqUri = $_SERVER['REQUEST_URI'];
				$this->sUri = str_replace ($sCurrentScriptDir, '', $sReqUri);
			} elseif (stristr($sServerType, 'cherokee')) {
				// TODO
			}

			// removing unnecessary get vars
			$iQMarkPos = strpos ($this->sUri, '?');
			if ($iQMarkPos) {
				$this->sUri = substr ($this->sUri, 0, $iQMarkPos);
			}
		}
		if ($bUrlDecode) {
			$this->sUri = urldecode ($this->sUri);
		}

		return $this->sUri;
	}

	public function getUriObject() {
		if (!($this->oUri instanceof vscUrlRWParser)) {
			$this->oUri = new vscUrlRWParser($this->getUri());
		}
		return $this->oUri;
	}
}
