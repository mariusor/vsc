<?php
namespace vsc\infrastructure\urls;

use vsc\infrastructure\BaseObject;
use vsc\presentation\requests\HttpRequestA;

class UrlParserA extends BaseObject implements UrlParserInterface {
	static protected $queryEncodingType = PHP_QUERY_RFC1738;

	private $sUrl;
	/**
	 * @var Url
	 */
	private $oUrl;

	/**
	 * @param string $sUrl
	 */
	public function __construct($sUrl = null) {
		$this->setUrl($sUrl);
	}

	/**
	 * @return string
	 */
	public function __toString() {
		return $this->getCompleteUri();
	}

	/**
	 * This is somewhat ugly.
	 *  Returns an instance of the class on which the method is called
	 * @return Url
	 */
	public static function getCurrentUrl() {
		return static::parse_url(static::getRequestUri());
	}

	/**
	 * @return string
	 */
	public static function getRequestUri() {
		if (is_array($_SERVER) && array_key_exists('REQUEST_URI', $_SERVER)) {
			if (array_key_exists('HTTP_HOST', $_SERVER)) {
				$uri = 'http' . (HttpRequestA::isSecure() ? 's' : '') . '://' . $_SERVER['HTTP_HOST'];
			} else {
				$uri = '';
			}
			$uri .= $_SERVER['REQUEST_URI'];
		} else {
			$uri = '';
		}
		return $uri;
	}

	/**
	 * @param string $sUrl
	 * @return bool
	 */
	public static function urlHasScheme($sUrl) {
		$firstPos = min(strpos($sUrl, ':'), strpos($sUrl, '/'));
		$sScheme = substr($sUrl, 0, $firstPos);
		return Url::isValidScheme($sScheme);
	}

	/**
	 * @param Url $oUrl
	 * @param array $aParsed
	 * @return Url
	 */
	private static function loadParsedUrl($oUrl, $aParsed) {
		if (isset($aParsed['scheme'])) {
			$oUrl->setScheme($aParsed['scheme']);
		}
		if (isset($aParsed['host'])) {
			$oUrl->setHost($aParsed['host']);
		}
		if (isset($aParsed['port'])) {
			$oUrl->setPort($aParsed['port']);
		}
		if (isset($aParsed['path'])) {
			$oUrl->setPath($aParsed['path']);
		}
		if (isset($aParsed['query'])) {
			$oUrl->setRawQuery($aParsed['query']);
		}
		if (isset($aParsed['fragment'])) {
			$oUrl->setFragment($aParsed['fragment']);
		}
		return $oUrl;
	}

	/**
	 * This exists as the php::parse_url function sometimes breaks inexplicably
	 * @param string $sUrl
	 * @return Url
	 */
	protected static function parse_url($sUrl = null) {
		if (is_null($sUrl)) {
			return new Url();
		}
		if (!stristr($sUrl, '://') && (substr($sUrl, 0, 2) != '//')) {
			$oUrl = new Url();
			$oUrl->setScheme('file');
			$oUrl->setPath($sUrl);
			return $oUrl;
		}

		try {
			if (!self::urlHasScheme($sUrl)) {
				$sUrl = (HttpRequestA::isSecure() ? 'https:' : 'http:') . $sUrl;
			}

			if (mb_detect_encoding($sUrl) !== 'ASCII') {
				$sUrl = rawurlencode($sUrl);
			}
			$aParsed = parse_url($sUrl);
			return self::loadParsedUrl(new Url(), $aParsed);
		} catch (\Exception $e) {
			// failed php::parse_url
			return new Url();
		}
	}

	/**
	 * @param string $sUrl
	 */
	public function setUrl($sUrl) {
		$this->sUrl = $sUrl;
		$this->oUrl = static::parse_url($sUrl);
	}

	private function getSubdomainOf($sRootDomain) {
		$sHost = strtolower($this->oUrl->getHost());
		$sSubDomains = stristr($sHost, '.' . $sRootDomain, true);

		return self::getTldOf($sSubDomains);
	}

	public static function getTldOf($sHost) {
		if (ip2long($sHost) > 0 || empty($sHost)) { return false; }

		if (!strrpos($sHost, '.')) {
			return $sHost;
		} else {
			return substr($sHost, strrpos($sHost, '.') + 1);
		}
	}

	public static function getCurrentHostName() {
		return $_SERVER['HTTP_HOST'];
	}

	public function getParentPath($iSteps = 0) {
		$sPath = self::normalizePath($this->oUrl->getPath());


		$len = strlen($sPath);
		$bHasPrefixSlash = (($len > 0) && ($sPath[0] == '/'));
		$bHasSuffixSlash = (($len > 1) && ($sPath[$len - 1] == '/'));

		// removing the folders from the path if there are parent references (../)
		$sPath = trim($sPath, '/');
		$aPath = explode('/', $sPath);

		if ($iSteps > 0) {
			// removing last $iSteps components of the path
			$aPath = array_slice($aPath, 0, -$iSteps);
		}

		// in case of actually getting the parent, we need to append the ending /
		// as we don't have a file as the last element in the path - same case for paths without a good termination
		$sPath = ($bHasPrefixSlash ? '/' : '') . implode('/', $aPath) . ($bHasSuffixSlash ? '/' : '');
		return $sPath;
	}

	public function setPath($sPath) {
		$this->oUrl->setPath($sPath);
	}

	public function getPath() {
		return $this->getParentPath(0);
	}

	/**
	 * @param string $sPath
	 * @return bool
	 */
	public static function isAbsolutePath($sPath) {
		return substr($sPath, 0, 1) == '/';
	}

	/**
	 * @return Url
	 */
	static public function getSiteUri() {
		return static::url(static::getRequestUri())->getHost();
	}

	/**
	 * @param int $iSteps
	 * @return string
	 * @internal param bool $bFull
	 */
	public function getCompleteParentUri($iSteps = 1) {
		$sUrl = $this->oUrl->getScheme() .
			$this->oUrl->getHost() .
			$this->getParentPath($iSteps) .
			$this->oUrl->getRawQueryString() .
			$this->oUrl->getFragment();

		return $sUrl;
	}

	/**
	 * @return string
	 * @internal param bool $bFull
	 */
	public function getCompleteUri() {
		return $this->getCompleteParentUri(0);
	}

	/**
	 * @param string $sUri
	 * @param string $sTermination
	 * @return bool
	 */
	public static function hasGoodTermination($sUri, $sTermination = '/') {
		// last element should be an / or in the last part after / there should be a .
		return (substr($sUri, -1) == $sTermination || stristr(substr($sUri, strrpos($sUri, $sTermination)), '.'));
	}

	/**
	 * @param string $sUrl
	 * @return Url
	 */
	static public function url($sUrl) {
		return static::parse_url($sUrl);
	}

	/**
	 * @param string $sPath
	 * @return string
	 */
	static public function normalizePath($sPath) {
		if (empty ($sPath)) {
			return '';
		}

		$len = strlen($sPath);
		$bHasPrefixSlash = ($sPath[0] == '/');
		$bHasSuffixSlash = (($len > 1) && ($sPath[$len - 1] == '/'));
		// removing the folders from the path if there are parent references (../)
		$sPath = trim($sPath, '/');
		$aPath = explode('/', $sPath);

		$iCnt = 0;
		foreach ($aPath as $iKey => $sFolder) {
			switch ($sFolder) {
				case '..':
					$iCnt++;

					unset ($aPath[$iKey]);
					if (array_key_exists($iKey - 1, $aPath)) {
						$iPrevKey = $iKey - 1;
					} else {
						$sPrev = prev($aPath);
						$iPrevKey = array_search($sPrev, $aPath);
					}
					unset ($aPath[$iPrevKey]);
					break;
				case '.':
				case '':
					unset ($aPath[$iKey]);
					break;
			}
		}

		$sPath = ($bHasPrefixSlash ? '/' : '');
		if (count($aPath) > 0) {
			$sPath .= implode('/', $aPath) . ($bHasSuffixSlash ? '/' : '');
		}

		return $sPath;
	}
}
