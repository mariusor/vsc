<?php
/**
 * @package presentation
 * @subpackage requests
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.07.13
 */
namespace vsc\presentation\requests;

use vsc\infrastructure\Object;
use vsc\infrastructure\urls\Url;
use vsc\infrastructure\urls\UrlParserA;
use vsc\Exception;

abstract class HttpRequestA extends Object {
	use GetRequest;
	use PostRequest;
	use CookieRequest;
	use FilesRequest;
	use SessionRequest;
	use AuthenticatedRequest;
	use ServerRequest;

	protected $sUri = null;
	/**
	 * @var Url
	 */
	protected $oUri;
	static private $aVarOrder;

	protected $sAuthorization	= '';
	protected $iContentLength	= 0; // ? I don't think I'm interested in the length of the request

	public function __construct() {
		if (isset($_COOKIE)) {
			$this->initCookie($_COOKIE);
		}
		if (isset($_FILES)) {
			$this->initFiles($_FILES);
		}
		if (isset($_SERVER)) {
			$this->initServer($_SERVER);
		}
		$this->initGet($_GET);
		$this->initPost($_POST);
		$this->initSession();
	}

	/**
	 * @return array
	 */
	public static function getVarOrder() {
		if (count(self::$aVarOrder) != 4) {
			// get gpc order
			$sOrder = ini_get('variables_order');
			for ($i = 0; $i < 4; $i++) {
				// reversing the order
				self::$aVarOrder[$i] = substr($sOrder, $i, 1);
			}
		}
		return self::$aVarOrder;
	}

	/**
	 * @return array
	 */
	public function getVars() {
		$aRet = array();
		foreach (self::getVarOrder() as $sMethod) {
			switch ($sMethod) {
			case 'S':
				if (self::hasSession()) {
					$aRet = array_merge($aRet, $this->aSessionVars);
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
		foreach (self::getVarOrder() as $sMethod) {
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

	/**
	 * @param string $sContentType
	 * @return bool
	 */
	public static function validContentType($sContentType) {
		return (preg_match('/^([-a-z]+|\*{1})\/([-a-z\+\.]+|\*{1})(;.*)?$/i', $sContentType) > 0);
	}

	/**
	 * @param string $sVarName
	 * @return bool
	 */
	public function hasVar($sVarName) {
		return (
			$this->hasGetVar($sVarName) ||
			$this->hasPostVar($sVarName) ||
			$this->hasSessionVar($sVarName) ||
			$this->hasCookieVar($sVarName)
		);
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
	 *        "^/([^?]*)?(.*)$" => "/index.php$2" <- this doesn't look right to me
	 *  )
	 *
	 * @todo move to the UrlRWParser
	 * @param bool $bUrlDecode
	 * @return string
	 */
	public function getUri($bUrlDecode = false) {
		if (!$this->sUri && isset($_SERVER['REQUEST_URI'])) {
			// this header is present for all servers in the same form
			if (isset($_SERVER['PHP_SELF'])) {
				$sCurrentScriptDir = dirname($_SERVER['PHP_SELF']) != '/' ? dirname($_SERVER['PHP_SELF']) : '';
			} else {
				$sCurrentScriptDir = '';
			}
			$sReqUri = $_SERVER['REQUEST_URI'];
			$this->sUri = str_replace($sCurrentScriptDir, '', $sReqUri);

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

	/**
	 * @return Url
	 */
	public function getUriObject() {
		if (!Url::isValid($this->oUri)) {
			$this->oUri = UrlParserA::url($this->getUri());
		}
		return $this->oUri;
	}

	static public function getDecodedVar($mVar) {
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
