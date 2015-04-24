<?php
namespace vsc\infrastructure\urls;

use vsc\infrastructure\vsc;
use vsc\infrastructure\Object;
use vsc\presentation\requests\HttpRequestA;
use vsc\ExceptionError;

class UrlParserA extends Object implements UrlParserI {
	static protected $QUERY_ENCODING_TYPE = PHP_QUERY_RFC1738;

	private $sUrl;
	private $aComponents = [
		'scheme'	=> '',
		'host'		=> '',
		'user'		=> '',
		'pass'		=> '',
		'path'		=> '',
		'query'		=> [],
		'fragment'	=> ''
	];

	static private $validSchemes = ['http', 'https', 'file'];

	/**
	 * @param string $sUrl
	 */
	public function __construct($sUrl = null) {
		if (!is_null($sUrl)) {
			$this->setUrl($sUrl);
		}
	}

	/**
	 * @return string
	 */
	public function __toString() {
		return $this->getCompleteUri(true);
	}

	/**
	 * This is somewhat ugly.
	 *  Returns an instance of the class on which the method is called
	 * @return UrlParserA
	 */
	public static function getCurrentUrl() {
		return new static(static::getRequestUri());
	}

	/**
	 * @return bool
	 */
	public function hasScheme() {
		return self::urlHasScheme($this->getUrl());
	}

	/**
	 * @return string
	 */
	public static function getRequestUri() {
		if (is_array($_SERVER) && array_key_exists('REQUEST_URI', $_SERVER)) {
			if (array_key_exists('HTTP_HOST', $_SERVER)) {
				$uri = 'http'.(HttpRequestA::isSecure() ? 's' : '').'://'.$_SERVER['HTTP_HOST'];
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
		$sScheme = substr($sUrl, 0, strpos($sUrl, ':'));
		return in_array($sScheme, self::$validSchemes);
	}

	/**
	 * This exists as the php::parse_url function sometimes breaks inexplicably
	 * @param string $sUrl
	 * @return array
	 */
	protected static function parse_url($sUrl = null) {
		if (is_null($sUrl)) {
			$sUrl = static::getRequestUri();
		}

		$bIsSecure = false;
		$sScheme = '';
		$sHost = '';
		$sUser = '';
		$sPass = '';
		$sFragment = '';
		$aReturn = [
			'scheme'	=> '',
			'host'		=> '',
			'user'		=> '',
			'pass'		=> '',
			'path'		=> '',
			'query'		=> [],
			'fragment'	=> ''
		];

		try {
			if (!stristr($sUrl, '://') && is_file($sUrl) && is_readable($sUrl)) {
				$aReturn['scheme'] = 'file';
				$aReturn['path'] = $sUrl;
				return $aReturn;
			}
		} catch (\Exception $e) {
			// possible open basedir restriction
			$aReturn['scheme'] = 'file';
			$aReturn['path'] = $sUrl;
			return $aReturn;
		}

		try {
			if (!self::urlHasScheme($sUrl)) {
				$sUrl = (HttpRequestA::isSecure() ? 'https:' : 'http:').$sUrl;
			}

			$aParsed = parse_url($sUrl);
			if (!is_array($aParsed)) {
				return array();
			}
			if (array_key_exists('query', $aParsed)) {
				$aQuery = array();
				parse_str($aParsed['query'], $aQuery);

				$aParsed['query'] = $aQuery;
			}

			return array_merge($aReturn, $aParsed);
		} catch (\Exception $e) {
			// failed php::parse_url
		}
	}

	public function setUrl($sUrl) {
		$this->sUrl = $sUrl;
		$this->aComponents = static::parse_url($sUrl);
	}

	public function getScheme() {
		return (array_key_exists('scheme', $this->aComponents) ? strtolower($this->aComponents['scheme']) : null);
	}

	public function getUser() {
		return $this->aComponents['user'];
	}

	public function getPass() {
		return $this->aComponents['pass'];
	}

	public function getPort() {
		return (array_key_exists('port', $this->aComponents) ? $this->aComponents['port'] : null);
	}

	private function getSubdomainOf($sRootDomain) {
		$sHost = strtolower($this->aComponents['host']);
		$sSubDomains = stristr($sHost, '.'.$sRootDomain, true);

		return self::getTldOf($sSubDomains);
	}

	public static function getTldOf($sHost) {
		if (ip2long($sHost) > 0 || empty($sHost)) { return false; }

		if (!strrpos($sHost, '.')) {
			return $sHost;
		} else {
			return substr($sHost, strrpos($sHost, '.')+1);
		}
	}

	public function getSubdomain() {
		return $this->getSubdomainOf($this->getDomain());
	}

	public function getDomain() {
		$sTld = $this->getTLD();
		return $this->getSubdomainOf($sTld).'.'.$sTld;
	}

	public function getTLD($sString = null) {
		if (is_null($sString)) {
			$sString = $this->aComponents['host'];
		}
		return self::getTldOf($sString);
	}

	public static function getCurrentHostName() {
		return $_SERVER['HTTP_HOST'];
	}

	public function getHost() {
		return strtolower($this->aComponents['host']);
	}

	public function getParentPath($iSteps = 0) {
		$sPath = $this->aComponents['path'];

		if (empty ($sPath)) {
			return '';
		}

		if (!self::isAbsolutePath($sPath)) {
			if (substr($sPath, 0, 2) == './') {
				$sPath = substr($sPath, 2);
			}
		}

		// removing the folders from the path if there are parent references (../)
		$sPath = trim($sPath, '/');
		$aPath = explode('/', $sPath);

		$iCnt = 0;
		foreach ($aPath as $iKey => $sFolder) {
			switch ($sFolder) {
			case '..':
				$iCnt++;

				unset ($aPath[$iKey]);
				if (array_key_exists($iKey-1, $aPath)) {
					$iPrevKey = $iKey-1;
				} else {
					$sPrev = prev($aPath);
					$iPrevKey = array_search($sPrev, $aPath);
				}
				unset ($aPath[$iPrevKey]);
			break;
			case '.':
				unset ($aPath[$iKey]);
			break;
			}
		}

		if ($iSteps > 0) {
			// removing last $iSteps components of the path
			$aPath = array_slice($aPath, 0, -$iSteps);
		}

		$sPath = (count($aPath) > 0 ? '/'.implode('/', $aPath) : '');
		// in case of actually getting the parent, we need to append the ending /
		// as we don't have a file as the last element in the path - same case for paths without a good termination
		if ($iSteps > 0 || !self::hasGoodTermination($sPath)) {
			$sPath .= '/';
		}
		return $sPath;
	}

	public function setPath($sPath) {
		$this->aComponents['path'] = $sPath;
	}

	public function getPath() {
		return $this->getParentPath(0);
	}

	/**
	 * @param string $sPath
	 * @returns UrlParserA
	 */
	public function addPath($sPath) {
		if (substr($this->aComponents['path'], -1) != '/') {
			$this->aComponents['path'] .= '/';
		}
		$this->aComponents['path'] .= $sPath;
		return $this;
	}

	/**
	 * @param string $sFragment
	 * @returns UrlParserA
	 */
	public function addFragment($sFragment) {
		$this->aComponents['fragment'] = $sFragment;
		return $this;
	}

	public function getQuery() {
		return $this->aComponents['query'];
	}

	public function setQueryParameters($aInc) {
		$this->aComponents['query'] = $aInc;
	}

	public function getQueryString() {
		if (!empty($this->aComponents['query'])) {
			try {
				return http_build_query($this->aComponents['query'], '', '', static::$QUERY_ENCODING_TYPE);
			} catch (\Exception $e) {
				//d ($this->aComponents);
			}
		}
		return '';
	}

	public function getFragment() {
		return $this->aComponents['fragment'];
	}

	/**
	 * @return string
	 */
	public function getUrl() {
		return $this->sUrl;
	}

	protected function getFullQueryString() {
		$sQuery = $this->getQueryString();
		if ($sQuery) {
			return '?'.$sQuery;
		} else {
			return '';
		}
	}

	protected function getFullFragmentString() {
		$sFragment = $this->getFragment();
		if ($sFragment) {
			return '#'.$sFragment;
		} else {
			return '';
		}
	}

	public function isLocal() {
		return ($this->getScheme() == 'file' && empty($this->aComponents['host']) && !empty($this->aComponents['path']));
	}

	public static function isAbsolutePath($sPath) {
		return substr($sPath, 0, 1) == '/';
	}

	public function getSiteUri() {
		if (empty($this->sUrl)) {
			return null;
		}
		// ff just tries to log you in... and removes the user:pass from the url :(
		$sUri = ($this->getUser() ? $this->getUser().($this->getPass() ? ':'.$this->getPass() : '').'@' : '');
		if ($this->getHost()) {
			$sUri .= $this->getHost();
		}

		if ($sUri) {
			return $sUri;
		} else {
			return '';
		}
	}

	public function getCompleteParentUri($bFull = false, $iSteps = 1) {
		if (empty($this->sUrl)) {
			return '';
		}
		if (!$this->isLocal()) {
			$sUrl = ($this->getScheme() ? $this->getScheme().':' : '').'//';
			$sUrl .= $this->getSiteUri();
		} else {
			$sUrl = '';
			if ($bFull) {
				$sUrl = ($this->getScheme() ? $this->getScheme().':' : '').'//';
			}
		}

		$sPath = $this->getParentPath($iSteps);
		if (self::isAbsolutePath($sPath)) {
			$sUrl .= $sPath;
		} else {
			try {
				$sUrl .= $this->aComponents['path'].$sPath;
			} catch (ExceptionError $e) {
				vsc::d($e->getTraceAsString());
			}
		}

		$sUrl .= $this->getFullQueryString();
		$sUrl .= $this->getFullFragmentString();

		return $sUrl;
	}

	public function getCompleteUri($bFull = false) {
		return $this->getCompleteParentUri($bFull, 0);
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

	public function changeSubdomain($sNewSubdomain) {
		$this->aComponents['host'] = str_ireplace($this->getSubdomain(), $sNewSubdomain, $this->aComponents['host']);
		return $this->aComponents['host'];
	}
}
