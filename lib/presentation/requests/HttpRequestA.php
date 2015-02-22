<?php
/**
 * @package presentation
 * @subpackage requests
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.07.13
 */
namespace vsc\presentation\requests;

use vsc\infrastructure\Object;
use vsc\infrastructure\urls\UrlRWParser;
use vsc\Exception;

abstract class HttpRequestA extends Object {
	use GetRequestT;
	use PostRequestT;
	use CookieRequestT;
	use FilesRequestT;
	use SessionRequestT;
	use AuthenticatedRequestT;

	protected $sUri = null;
	protected $oUri;
	protected $sHttpMethod;
	protected $sServerName;
	protected $sServerProtocol;
	protected $aVarOrder;

	protected $aAccept = array();
	protected $aAcceptCharset = array();
	protected $aAcceptEncoding	= array();
	protected $aAcceptLanguage	= array();

	protected $sAuthorization	= '';
	protected $iContentLength	= 0; // ? I don't think I'm interested in the length of the request
	protected $sContentType		= '';

	protected $sIfModifiedSince = '';
	protected $sIfNoneMatch		= '';

	protected $sReferer = '';
	protected $sUserAgent = '';

	protected $bDoNotTrack = false;

	public function __construct() {
		$this->initGet();
		$this->initPost();
		$this->initCookie();
		$this->initFiles();
		$this->initSession();

		if (isset($_SERVER)) {
			$this->getServerProtocol();
			$this->getHttpMethod();

			if (isset ($_SERVER['HTTP_ACCEPT']) && !empty($_SERVER['HTTP_ACCEPT'])) {
				$this->aAccept = explode(',', $_SERVER['HTTP_ACCEPT']);
			}

			if (isset ($_SERVER['HTTP_ACCEPT_LANGUAGE']) && !empty($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
				$this->aAcceptLanguage = explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE']);
			}
			if (isset ($_SERVER['HTTP_ACCEPT_ENCODING']) && !empty($_SERVER['HTTP_ACCEPT_ENCODING'])) {
				$this->aAcceptEncoding = explode(',', $_SERVER['HTTP_ACCEPT_ENCODING']);
			}
			if (isset ($_SERVER['HTTP_ACCEPT_CHARSET']) && !empty($_SERVER['HTTP_ACCEPT_CHARSET'])) {
				$this->aAcceptCharset = explode(',', $_SERVER['HTTP_ACCEPT_CHARSET']);
			}

			if (isset ($_SERVER['HTTP_USER_AGENT']) && !empty($_SERVER['HTTP_USER_AGENT'])) {
				$this->sUserAgent = $_SERVER['HTTP_USER_AGENT'];
			}
			if (isset ($_SERVER['HTTP_REFEER']) && !empty($_SERVER['HTTP_REFEER'])) {
				$this->sReferer = $_SERVER['HTTP_REFERER'];
			}

			if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) && !empty($_SERVER['HTTP_IF_MODIFIED_SINCE'])) {
				$this->sIfModifiedSince = $_SERVER['HTTP_IF_MODIFIED_SINCE'];
			}

			if (isset($_SERVER['HTTP_IF_NONE_MATCH']) && !empty($_SERVER['HTTP_IF_NONE_MATCH'])) {
				$this->sIfNoneMatch = $_SERVER['HTTP_IF_NONE_MATCH'];
			}

			if ($this->hasContentType()) {
				if (stripos($_SERVER['CONTENT_TYPE'], ';') !== false) {
					$this->sContentType = substr($_SERVER['CONTENT_TYPE'], 0, stripos($_SERVER['CONTENT_TYPE'], ';'));
				} else {
					$this->sContentType = $_SERVER['CONTENT_TYPE'];
				}
			}

			if (isset($_SERVER['HTTP_DNT'])) {
				$this->bDoNotTrack = (bool)$_SERVER['HTTP_DNT'];
			}
			if (isset($_SERVER['PHP_AUTH_DIGEST'])) {
				// DIGEST authorization attempt
				$this->setAuthentication(new DigestHttpAuthentication($_SERVER['PHP_AUTH_DIGEST'], $_SERVER['REQUEST_METHOD']));
			}
			if (isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])) {
				$this->setAuthentication(new BasicHttpAuthentication($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']));
			}
		}
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
	public function getServerProtocol() {
		if (!$this->sServerProtocol && isset ($_SERVER['SERVER_PROTOCOL'])) {
			$this->sServerProtocol = $_SERVER['SERVER_PROTOCOL'];
		}

		return $this->sServerProtocol;
	}

	/**
	 * @return array
	 */
	public function getHttpAccept() {
		return $this->aAccept;
	}

	/**
	 * @return array
	 */
	public function getHttpAcceptCharset() {
		return $this->aAcceptCharset;
	}

	/**
	 * @return string
	 */
	public function getContentType() {
		return $this->sContentType;
	}

	/**
	 * @return array
	 */
	public function getHttpAcceptEncoding() {
		return $this->aAcceptEncoding;
	}

	/**
	 * @return array
	 */
	public function getHttpAcceptLanguage() {
		return $this->aAcceptLanguage;
	}

	/**
	 * @return string
	 */
	public function getIfModifiedSince() {
		return $this->sIfModifiedSince;
	}

	/**
	 * @return string
	 */
	public function getIfNoneMatch() {
		return $this->sIfNoneMatch;
	}

	/**
	 * @return string
	 */
	public function getHttpReferer() {
		return $this->sReferer;
	}

	/**
	 * @return string
	 */
	public function getHttpUserAgent() {
		return $this->sUserAgent;
	}

	/**
	 * @return bool
	 */
	public function getDoNotTrack() {
		return $this->bDoNotTrack;
	}

	/**
	 * @return array
	 */
	public function getVarOrder() {
		if (count($this->aVarOrder) != 4) {
			// get gpc order
			$sOrder = ini_get('variables_order');
			for ($i = 0; $i < 4; $i++) {
				// reversing the order
				$this->aVarOrder[$i] = substr($sOrder, $i, 1);
			}
		}
		return $this->aVarOrder;
	}

	public function getVars() {
		$aRet = array();
		foreach ($this->getVarOrder() as $sMethod) {
			switch ($sMethod) {
			case 'S':
				if (self::hasSession()) {
					$aRet = array_merge($aRet, $_SESSION);
				}
				break;
			case 'C':
				$aRet = array_merge($aRet, $this->aCookieVars);
				break;
			case 'P':
				$aRet = array_merge($aRet, $this->aPostVars);
				break;
			case 'G':
				$aRet = array_merge($aRet, $this->aGetVars);
				break;
			}
		}
		return $aRet;
	}

	/**
	 * @param string $sVarName
	 * @throws Exception
	 * @return mixed
	 */
	public function getVar($sVarName) {
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
				if (self::hasSession()) {
					$mVal = $this->getSessionVar($sVarName);
				}
				break;
			}
			if (isset($mVal)) {
				return $mVal;
			}
		}
		return null;
	}

	public static function hasContentType() {
		return (array_key_exists('CONTENT_TYPE', $_SERVER) && strlen($_SERVER['CONTENT_TYPE']) > 0);
	}

	public static function validContentType($sContentType) {
		return true;
	}

	public function hasVar($sVarName) {
		return (
			$this->hasGetVar($sVarName) ||
			$this->hasPostVar($sVarName) ||
			$this->hasSessionVar($sVarName) ||
			$this->hasCookieVar($sVarName)
		);
	}

	public function getHttpMethod() {
		if (!$this->sHttpMethod && isset ($_SERVER['REQUEST_METHOD'])) {
			$this->sHttpMethod = $_SERVER['REQUEST_METHOD'];
		}
		return $this->sHttpMethod;
	}

	/**
	 * @return bool
	 */
	public function isGet() {
		return ($this->getHttpMethod() == HttpRequestTypes::GET);
	}

	/**
	 * @return bool
	 */
	public function isHead() {
		return ($this->getHttpMethod() == HttpRequestTypes::HEAD);
	}

	/**
	 * @return bool
	 */
	public function isPost() {
		return ($this->getHttpMethod() == HttpRequestTypes::POST);
	}

	/**
	 * @return bool
	 */
	public function isPut() {
		return ($this->getHttpMethod() == HttpRequestTypes::PUT);
	}

	/**
	 * @return bool
	 */
	public function isDelete() {
		return ($this->getHttpMethod() == HttpRequestTypes::DELETE);
	}

	/**
	 * @return bool
	 */
	public static function isSecure() {
		return (array_key_exists('HTTPS', $_SERVER) && $_SERVER['HTTPS'] == 'on');
	}

	/**
	 * @param string $sMimeType
	 * @return bool
	 */
	public function accepts($sMimeType) {
		return ContentType::isAccepted($sMimeType, $this->getHttpAccept());
	}

	/**
	 * Returns the REQUEST_URI which is used to get the URL Rewrite variables
	 * This will also remove the part of the path that is actually an existing path
	 * lighttpd:
	 *  url.rewrite = (
	 * 		"^/([^?]*)?(.*)$" => "/index.php$2" <- this doesn't look right to me
 	 *  )
	 *
	 * @todo move to the UrlRWParser
	 * @return string
	 */
	public function getUri($bUrlDecode = false) {
		if (!$this->sUri && isset($_SERVER['SERVER_SOFTWARE'])) {
			$sServerType = $_SERVER['SERVER_SOFTWARE'];

			// this header is present for all servers in the same form
			$sCurrentScriptDir = dirname($_SERVER['PHP_SELF']) != '/' ? dirname($_SERVER['PHP_SELF']) : '';
			if (stristr($sServerType, 'lighttpd')) {
				$sReqUri = $_SERVER['REQUEST_URI'];
				$this->sUri = str_replace($sCurrentScriptDir, '', $sReqUri);
			} elseif (stristr($sServerType, 'apache')) {
				$sCurrentScriptDir = dirname($_SERVER['SCRIPT_FILENAME']) != '/' ? dirname($_SERVER['SCRIPT_FILENAME']) : '';
				$sReqUri = $_SERVER['SCRIPT_URL']; // apache 2.4 with mod_rewrite
				$this->sUri = str_replace($sCurrentScriptDir, '', $sReqUri);
			} elseif (stristr($sServerType, 'cherokee')) {
				// TODO
			}

			// removing unnecessary get vars
			$iQMarkPos = strpos($this->sUri, '?');
			if ($iQMarkPos) {
				$this->sUri = substr($this->sUri, 0, $iQMarkPos);
			}
		}
		if ($bUrlDecode) {
			$this->sUri = urldecode($this->sUri);
		}

		return $this->sUri;
	}

	public function getUriObject() {
		if (!UrlRWParser::isValid($this->oUri)) {
			$this->oUri = new UrlRWParser($this->getUri());
		}
		return $this->oUri;
	}

	static protected function getDecodedVar($mVar) {
		if (is_array($mVar)) {
			foreach ($mVar as $key => $sValue) {
				$mVar[$key] = self::getDecodedVar($sValue);
			}
		} elseif (is_string($mVar)) {
			$mVar = urldecode($mVar);
		}
		return $mVar;
	}
}
