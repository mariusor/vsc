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

	private $bDoNotTrack		= false;

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

		if (isset($_SERVER['CONTENT_TYPE'])) {
			$this->sContentType = substr ($_SERVER['CONTENT_TYPE'], 0, stripos($_SERVER['CONTENT_TYPE'], ';'));
		}

		if (isset($_SERVER['HTTP_DNT'])) {
			$this->bDoNotTrack = (bool)$_SERVER['HTTP_DNT'];
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
	 * @return string
	 */
	public function getContentType () {
		return $this->sContentType;
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

	public function getSessionVars() {
		return $this->aSessionVars;
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
			case 'S':
				$aRet = array_merge ($aRet, $this->aSessionVars);
				break;
			case 'C':
				$aRet = array_merge ($aRet, $this->aCookieVars);
				break;
			case 'P':
				$aRet = array_merge ($aRet, $this->aPostVars);
				break;
			case 'G':
				$aRet = array_merge ($aRet, $this->aGetVars);
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
				$mVal = $this->getCookieVar($sVarName);
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

	public function hasGetVars () {
		return (count($this->aGetVars) > 0);
	}
	public function hasGetVar ($sVarName) {
		return key_exists($sVarName, $this->aGetVars);
	}
	public function hasPostVars () {
		return (count( $this->aPostVars) > 0);
	}
	public function hasPostVar ($sVarName) {
		return key_exists($sVarName, $this->aPostVars);
	}
	public function hasSessionVar ($sVarName) {
		return key_exists($sVarName, $this->aSessionVars);
	}
	public function hasCookieVar ($sVarName) {
		return key_exists($sVarName, $this->aCookieVars);
	}

	static public function startSession ($sSessionName = null) {
		if ( ((double)PHP_VERSION >= 5.4 && session_status() == PHP_SESSION_DISABLED) ) {
			throw new vscExceptionRequest('Sessions are not available');
		}

		if ( ((double)PHP_VERSION >= 5.4 && session_status() == PHP_SESSION_NONE) || session_id() == "") {
			$oRequest = vsc::getEnv()->getHttpRequest();
			session_set_cookie_params(0, '/', $oRequest->getUriObject()->getDomain(), $oRequest->isSecure(), true);
			session_start();
			if (!is_null($sSessionName)) {
				session_name($sSessionName);
			}

			$oRequest->sessionLoad();
		}
	}

	static public function destroySession () {
		$aSessionCookieParams = session_get_cookie_params();

		session_unset();
		session_destroy();
		session_write_close();
		setcookie(session_name(), "", -1, $aSessionCookieParams['path'], $aSessionCookieParams['domain'], $aSessionCookieParams['secure'], $aSessionCookieParams['httponly']);
	}

	public function sessionLoad() {
		if (isset($_SESSION))
			$this->aSessionVars	= $_SESSION;
	}

	public function hasVar($sVarName) {
		return (
			$this->hasGetVar($sVarName) ||
			$this->hasPostVar($sVarName) ||
			$this->hasSessionVar($sVarName) ||
			$this->hasCookieVar($sVarName)
		);
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
			return self::getDecodedVar($this->aCookieVars[$sVarName]);
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
	public function getSessionVar ($sVarName) {
		if (key_exists($sVarName, $this->aSessionVars)) {
			return self::getDecodedVar($this->aSessionVars[$sVarName]);
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

	/**
	 * @param string $sVarName
	 * @param string $sVarValue
	 * @return bool
	 */
	public function setSessionVar ($sVarName, $sVarValue) {
		return $_SESSION[$sVarName] = $sVarValue;
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

	public function accepts ($sMimeType) {
		$aGoodMimeTypes = array ($sMimeType, '*/*');
		$aIncomingAcceptHeaders = $this->getHttpAccept();
		$aContentTypes = array();
		// 1. empty http-accept header
		if (empty ($aIncomingAcceptHeaders)) {
			$aGoodMimeTypes[] = 'text/html';
			$aGoodMimeTypes[] = 'text/xml';
		}
		// 2. non-empty http-accept header
		foreach ($aIncomingAcceptHeaders as $sEntry) {
			$iSemicolonPosition = strpos($sEntry, ';');
			if ($iSemicolonPosition > 0) {
				$sContentType = substr ($sEntry, 0, $iSemicolonPosition);
				$aContentTypes[] = $sContentType;
			} else {
				$aContentTypes[] = $sEntry;
			}
		}
		foreach ($aGoodMimeTypes as $sPotentialContentType) {
			if (in_array($sPotentialContentType, $aContentTypes)) {
				return true;
			}
		}
		return false;
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
		if (!vscUrlRWParser::isValid($this->oUri)) {
			$this->oUri = new vscUrlRWParser();
		}
		return $this->oUri;
	}

	static protected function getDecodedVar ($mVar) {
		if (is_array($mVar)) {
			foreach ($mVar as $key => $sValue) {
				$mVar[$key] = urldecode($sValue);
			}
		} elseif (is_string($mVar)) {
			$mVar = urldecode($mVar);
		}
		return $mVar;
	}
}
