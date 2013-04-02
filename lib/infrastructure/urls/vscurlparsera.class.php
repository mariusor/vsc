<?php
class vscUrlParserA extends vscObject implements vscUrlParserI {
	private $sUrl;
	private $aComponents;

	public function __construct ($sUrl = null) {
		if ($sUrl === null) {
			$sUrl = 'http' . (vscHttpRequestA::isSecure() ? 's' : '') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		}
		$this->setUrl($sUrl);
	}

	public function __toString() {
		return $this->getCompleteUri(true);
	}

	/**
	 * This exists as the php::parse_url function sometimes breaks inexplicably
	 * @param string $sUrl
	 * @return multitype:string multitype:
	 */
	static public function parse_url ($sUrl = null) {
		if (is_null($sUrl)) {
			$sUrl = $_SERVER['REQUEST_URI'];
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
			'query'		=> '',
			'fragment'	=> ''
		);

		try {
			if ( substr($sUrl, 0, 2) == '//' ) {
				$sUrl = (array_key_exists('HTTPS', $_SERVER) && $_SERVER['HTTPS'] ? 'https:' : 'http:') . $sUrl;
			}

			$aParsed = parse_url ($sLongUrl);

			if (array_key_exists('query', $aParsed)) {
				$aQuery = array();
				parse_str($aParsed['query'], $aQuery);

				$aParsed['query'] = $aQuery;
			}

			return array_merge ($aReturn, $aParsed);
		} catch (ErrorException $e) {
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

		return array (
			'scheme'	=> ($bIsSecure ? 'https' : 'http'),
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
		return $this->aComponents['port'];
	}

	private function getSubdomainOf ($sRootDomain) {
		$sHost = strtolower($this->aComponents['host']);
		$sSubDomains = stristr ($sHost, '.' . $sRootDomain, true);

		return $this->getTldOf($sSubDomains);
	}

	private function getTldOf ($sHost) {
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
		return $this->getTldOf($this->aComponents['host']);
	}

	static public function getCurrentHostName () {
		return $_SERVER['HTTP_HOST'];
	}

	public function getHost () {
		return strtolower($this->aComponents['host']);
	}

	public function getParentPath ($iSteps = 0) {
		$sPath = $this->aComponents['path'];

		if (empty ($sPath)) return '';

		if (!self::isAbsolutePath($sPath)) {
			if (substr ($sPath, 0, 2) == './'){
				$sPath = substr ($sPath, 2);
			}
			try {
				$sParentPath = substr (parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), 0 , -1);
				if (substr($sParentPath, -1) != '/') {
					$sParentPath .= '/';
				}
			} catch (vscExceptionError $e) {
				$sParentPath = '';
			}
			$sPath = $sParentPath . $sPath;
		}

		// removing the folders from the path if there are parent references (../)
		$sPath = trim($sPath, '/');
		$aPath = explode('/', $sPath);

		$iCnt = 0;
		foreach ($aPath as $iKey => $sFolder) {
			if ($sFolder == '..') {
				$iCnt++;

				unset ($aPath[$iKey]);
				if (key_exists($iKey-1,$aPath)) {
					$iPrevKey = $iKey-1;
					$sPrev = $aPath[$iPrevKey];
				} else {
					$sPrev = prev($aPath);
					$iPrevKey = array_search ($sPrev, $aPath);
				}
				unset ($aPath[$iPrevKey]);
//				if ($iCnt == 1) d (array($iPrevKey=>$sPrev), array($iKey=>$sFolder));
			} else {
				//$aPath[$iKey] = rawurlencode($sFolder);
			}
		}

		if ($iSteps > 0) {
			// removing last $iSteps components of the path
			$aPath = array_slice ($aPath, 0, -$iSteps);
		}

		$sPath = (count($aPath) > 0 ?  '/' . implode ('/', $aPath) : '');
		$sLast = end ($aPath);
		if (!self::hasGoodTermination($sPath)) { // we don't have a file as the last element in the path
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
	 * @return vscUrlParserA
	 */
	public function addPath ($sPath) {
		if (substr($this->aComponents['path'], -1) != '/') $this->aComponents['path'] .= '/';
		$this->aComponents['path'] .= $sPath;
		return $this;
	}

	/**
	 * @param string $sFragment
	 * @return vscUrlParserA
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
			} catch (Exception $e) {
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
		return (!$this->getScheme() && !$this->getHost() && $this->getPath());
	}

	public static function isAbsolutePath ($sPath) {
		return substr ($sPath, 0, 1) == '/';
	}

	public function getSiteUri () {
		$sUri = ($this->getScheme() ? $this->getScheme() : 'http') . '://';
		// ff just tries to log you in... and removes the user:pass from the url :(
		$sUri .= ($this->getUser() ? $this->getUser() . ($this->getPass() ? ':' . $this->getPass() : '') . '@' : '');
		$sUri .= ($this->getHost() ? $this->getHost() : $_SERVER['HTTP_HOST']);

		if ($sUri) {
			return $sUri;
		} else {
			throw new vscExceptionInfrastructure ('No host present...');
		}
	}

	public function getCompleteParentUri ($bFull = false, $iSteps = 1) {
		if (!$this->isLocal()) {
			$bFull = true;
		}
		$sUrl = '';

		if ($bFull) {
			$sUrl .= $this->getSiteUri();
		}

		$sPath = $this->getParentPath($iSteps);
		if (self::isAbsolutePath($sPath)) {
			$sUrl .= $sPath;
		} else {
			try {
				$sUrl .= $this->aComponents['path'] . $sPath;
			} catch (vscExceptionError $e) {
				d ($e->getTraceAsString());
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

	static public function hasGoodTermination ($sUri) {
		// last element should be an / or in the last part after / there should be a .
		return (substr($sUri, -1) == '/' || stristr(substr($sUri, strrpos($sUri, '/')), '.'));
	}

	public function changeSubdomain ($sNewSubdomain) {
		$this->aComponents['host'] = str_ireplace($this->getSubdomain(), $sNewSubdomain, $this->aComponents['host']);
		return $this->aComponents['host'];
	}
}
