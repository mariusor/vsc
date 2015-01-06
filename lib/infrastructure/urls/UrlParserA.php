<?php
namespace vsc\infrastructure\urls;

use vsc\infrastructure\vsc;
use vsc\infrastructure\Object;
use vsc\presentation\requests\HttpRequestA;
use vsc\ExceptionError;

class UrlParserA extends Object implements UrlParserI {
	private $sUrl;
	private $aComponents = array(
		'scheme'	=> '',
		'host'		=> '',
		'user'		=> '',
		'pass'		=> '',
		'path'		=> '',
		'query'		=> array(),
		'fragment'	=> ''
	);

	static private $validSchemes = array( 'http', 'https', 'file' );

	public function __construct ($sUrl = null) {
		if ( !is_null($sUrl) ) {
			$this->setUrl($sUrl);
		}
	}

	public function __toString() {
		return $this->getCompleteUri(true);
	}

	static public function getCurrentUrl () {
		return new UrlRWParser('http' . (HttpRequestA::isSecure() ? 's' : '') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
	}

	public function hasScheme () {
		return self::urlHasScheme($this->getUrl());
	}

	static public function urlHasScheme ($sUrl) {
		$sScheme = substr ($sUrl, 0, strpos($sUrl, ':'));
		return in_array($sScheme, self::$validSchemes);
	}

	/**
	 * This exists as the php::parse_url function sometimes breaks inexplicably
	 * @param string $sUrl
	 * @return string[]
	 */
	static public function parse_url ($sUrl = null) {
		if (is_null($sUrl) && is_array($_SERVER) && array_key_exists('REQUEST_URI', $_SERVER)) {
			$sUrl = self::getCurrentUrl();
		}

		$bIsSecure	= false;
		$sHost		= '';
		$sUser		= '';
		$sPass		= '';
		$sFragment	= '';
		$aReturn	= array(
			'scheme'	=> '',
			'host'		=> '',
			'user'		=> '',
			'pass'		=> '',
			'path'		=> '',
			'query'		=> array(),
			'fragment'	=> ''
		);

		try {
			if ( !stristr($sUrl, '://') && is_file ($sUrl) && is_readable($sUrl) ) {
				$aReturn['scheme'] = 'file';
				$aReturn['path'] = $sUrl;
				return $aReturn;
			}
		} catch (\ErrorException $e) {
			// possible open basedir restriction
			$aReturn['path'] = $sUrl;
		}

		try {
			if ( !self::urlHasScheme($sUrl) ) {
				$sUrl = (HttpRequestA::isSecure()  ? 'https:' : 'http:') . $sUrl;
			}

			if ( substr($sUrl, 0, 2) == '//' ) {
				$sUrl = substr ($sUrl, 2);
				$aReturn['host'] = substr ($sUrl, 0, strpos($sUrl,'/'));
				$sUrl = substr ($sUrl, strpos($sUrl, '/'));
			}

			$aParsed = parse_url ($sUrl);
			if (!is_array($aParsed)) {
				return array();
			}
			if (array_key_exists('query', $aParsed)) {
				$aQuery = array();
				parse_str($aParsed['query'], $aQuery);

				$aParsed['query'] = $aQuery;
			}

			return array_merge ($aReturn, $aParsed);
		} catch (\ErrorException $e) {
			// failed php::parse_url
		}

		if (stristr($sUrl, 'https://')) {
			$bIsSecure = true;
		}
		if (stristr($sUrl, 'http://')) {
			// stripping the protocol
			$sUrl = substr($sUrl, 7);
		}
		if (stristr($sUrl, 'https://')) {
			// stripping the protocol
			$sUrl = substr($sUrl, 8);
		}
		if (stristr($sUrl, '@')) {
			// getting the username (and pass)
			$sUser = substr($sUrl, 0, strpos ($sUrl, '@'));
			if (stristr($sUser, ':')) {
				$sPass = substr($sUser, strpos ($sUrl, ':')+1);
				$sUser = substr($sUser,0, strpos ($sUrl, ':'));
			}
			$sUrl = substr($sUrl, strpos ($sUrl, '@') + 1);
		}
		if (stristr($sUrl, '/')) {
			// getting the hostname
			$sHost = substr($sUrl, 0, strpos ($sUrl, '/'));
			$sUrl = substr($sUrl, strpos ($sUrl, '/') + 1 );
		}

		if (stristr($sUrl, '#')) {
			$sFragment	= substr ($sUrl, strpos($sUrl, '#') + 1);
			$sUrl = substr ($sUrl, 0, strpos($sUrl, '#'));
		}

		if (stristr($sUrl, '?')) {
			// we have a query part
			$sPath		= substr ($sUrl, 0 , strpos($sUrl, '?'));
			$sQuery		= substr ($sUrl, strpos($sUrl, '?') + 1);
		} else {
			$sPath		= stristr($sUrl, '/');
			$sQuery 	= '';
		}

		$aQuery = array();
		parse_str($sQuery, $aQuery);
		if ( self::urlHasScheme($sUrl) ) {
			$sScheme = $bIsSecure ? 'https' : 'http';
		}
		return array (
			'scheme'	=> $sScheme,
			'host'		=> $sHost,
			'user'		=> $sUser,
			'pass'		=> $sPass,
			'path'		=> $sPath,
			'query'		=> $aQuery,
			'fragment'	=> $sFragment
		);
	}

	public function setUrl ($sUrl) {
		$this->sUrl 		= $sUrl;
		$this->aComponents	= self::parse_url ($sUrl);
	}

	public function getScheme () {
		return strtolower($this->aComponents['scheme']);
	}

	public function getUser () {
		return $this->aComponents['user'];
	}

	public function getPass () {
		return $this->aComponents['pass'];
	}

	public function getPort () {
		return (array_key_exists('port', $this->aComponents) ?  $this->aComponents['port'] : null);
	}

	private function getSubdomainOf ($sRootDomain) {
		$sHost = strtolower($this->aComponents['host']);
		$sSubDomains = stristr ($sHost, '.' . $sRootDomain, true);

		return self::getTldOf($sSubDomains);
	}

	static public function getTldOf ($sHost) {
		if ( ip2long($sHost) > 0 || empty($sHost) ) { return false; }

		if (!strrpos ($sHost, '.')) {
			return $sHost;
		} else {
			return substr($sHost, strrpos ($sHost, '.') + 1);
		}
	}

	public function getSubdomain () {
		return $this->getSubdomainOf($this->getDomain());
	}

	public function getDomain () {
		$sTld = $this->getTLD();
		return $this->getSubdomainOf($sTld) . '.' . $sTld;
	}

	public function getTLD ($sString = null) {
		if (is_null($sString)) {
			$sString = $this->aComponents['host'];
		}
		return self::getTldOf($sString);
	}

	static public function getCurrentHostName () {
		return $_SERVER['HTTP_HOST'];
	}

	public function getHost () {
		return strtolower($this->aComponents['host']);
	}

	public function getParentPath ($iSteps = 0) {
		$sPath = $this->aComponents['path'];
		$sParentPath = '';

		if (empty ($sPath)) return '';

		if (!self::isAbsolutePath($sPath)) {
			if (substr ($sPath, 0, 2) == './'){
				$sPath = substr ($sPath, 2);
			}
			if (!vsc::isCli()) {
				try {
					$sParentPath = substr (parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), 0 , -1);
					if (substr($sParentPath, -1) != '/') {
						$sParentPath .= '/';
					}
				} catch (ExceptionError $e) {
					// err
				}
			}
			$sPath = $sParentPath . $sPath;
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
					if (array_key_exists($iKey-1,$aPath)) {
						$iPrevKey = $iKey-1;
						$sPrev = $aPath[$iPrevKey];
					} else {
						$sPrev = prev($aPath);
						$iPrevKey = array_search ($sPrev, $aPath);
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
			$aPath = array_slice ($aPath, 0, -$iSteps);
		}

		$sPath = (count($aPath) > 0 ?  '/' . implode ('/', $aPath) : '');
		$sLast = end ($aPath);
		// in case of actually getting the parent, we need to append the ending /
		// as we don't have a file as the last element in the path - same case for paths without a good termination
		if ($iSteps > 0 || !self::hasGoodTermination($sPath)) {
			$sPath .= '/';
		}
		return $sPath;
	}

	public function setPath ($sPath) {
		$this->aComponents['path'] = $sPath;
		$sPath = $this->aComponents['path'];
	}

	public function getPath () {
		return $this->getParentPath(0);
	}

	/**
	 * @param string $sPath
	 * @returns UrlParserA
	 */
	public function addPath ($sPath) {
		if (substr($this->aComponents['path'], -1) != '/') $this->aComponents['path'] .= '/';
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

	public function getQuery () {
		return $this->aComponents['query'];
	}

	public function setQueryParameters ($aInc) {
		$this->aComponents['query'] = $aInc;
	}

	public function getQueryString () {
		if (!empty($this->aComponents['query'])) {
			try {
				return urldecode (http_build_query ($this->aComponents['query']));
			} catch (\Exception $e) {
				//d ($this->aComponents);
			}
		}
		return '';
	}

	public function getFragment () {
		return $this->aComponents['fragment'];
	}

	public function getUrl () {
		return $this->sUrl;
	}

	public function getFullQueryString () {
		$sQuery = $this->getQueryString ();
		if ($sQuery) {
			return '?' . $sQuery;
		} else {
			return '';
		}
	}

	public function getFullFragmentString () {
		$sFragment = $this->getFragment();
		if ($sFragment) {
			return '#' . $sFragment;
		} else {
			return '';
		}
	}


	public function isLocal () {
		return ($this->getScheme() == 'file' && empty($this->aComponents['host']) && !empty($this->aComponents['path']));
	}

	public static function isAbsolutePath ($sPath) {
		return substr ($sPath, 0, 1) == '/';
	}

	public function getSiteUri () {
		// ff just tries to log you in... and removes the user:pass from the url :(
		$sUri = ($this->getUser() ? $this->getUser() . ($this->getPass() ? ':' . $this->getPass() : '') . '@' : '');
		if ( $this->getHost() ) {
			$sUri .= $this->getHost();
		} elseif (is_array($_SERVER) && array_key_exists('HTTP_HOST', $_SERVER)) {
			$sUri .= $_SERVER['HTTP_HOST'];
		}

		if ($sUri) {
			return $sUri;
		} else {
			return '';
		}
	}

	public function getCompleteParentUri ($bFull = false, $iSteps = 1) {
		if (!$this->isLocal()) {
			$bFull = true;
			$sUrl = ($this->getScheme() ? $this->getScheme() . ':' : '') . '//';
			$sUrl .= $this->getSiteUri();
		} else {
			$sUrl = '';
			if ($bFull) {
				$sUrl = ($this->getScheme() ? $this->getScheme() . ':' : '') . '//';
			}
		}

		$sPath = $this->getParentPath($iSteps);
		if (self::isAbsolutePath($sPath)) {
			$sUrl .= $sPath;
		} else {
			try {
				$sUrl .= $this->aComponents['path'] . $sPath;
			} catch (ExceptionError $e) {
				vsc::d ($e->getTraceAsString());
			}
		}

		if (substr($sPath, -1) != '/') {
			$sPath .= '/';
		}

		$sUrl .=  $this->getFullQueryString();
		$sUrl .=  $this->getFullFragmentString();

		return $sUrl;
	}

	public function getCompleteUri ($bFull = false) {
		return $this->getCompleteParentUri($bFull, 0);
	}

	static public function hasGoodTermination ($sUri, $sTermination = '/') {
		// last element should be an / or in the last part after / there should be a .
		return (substr($sUri, -1) == $sTermination || stristr(substr($sUri, strrpos($sUri, $sTermination)), '.'));
	}

	public function changeSubdomain ($sNewSubdomain) {
		$this->aComponents['host'] = str_ireplace($this->getSubdomain(), $sNewSubdomain, $this->aComponents['host']);
		return $this->aComponents['host'];
	}
}
