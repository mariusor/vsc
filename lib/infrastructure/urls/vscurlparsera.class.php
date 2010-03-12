<?php
class vscUrlParserA implements vscUrlParserI {
	private $sUrl;
	private $aComponents;

	public function __construct ($sUrl = null) {
		if (!$sUrl) {
			$this->setUrl($_SERVER['REQUEST_URI']);
		} else {
			$this->setUrl($sUrl);
		}
	}

	public function __toString() {
		return $this->getCompleteUri(true);
	}

	static private function parseUrl ($sUrl = null, $iComponent = -1) {
		$aComponents = array (
			'scheme'	=> vsc::getHttpRequest()->isSecure() ? 'https' : 'http',
			'user'		=> '',
			'pass'		=> '',
			'host'		=> vsc::getHttpRequest()->getServerName(),
			'port'		=> '',
			'path'		=> '',
			'query'		=> '',
			'fragment'	=> ''
		);

		try {
			$mRet = parse_url ($sUrl, $iComponent);
			if (is_array($mRet)){
				return array_merge (
					$aComponents,
					$mRet
				);
			} elseif (is_string($mRet)) {
				return $mRet;
			}
		} catch (vscErrorException $e) {
			// parse url failed, we should do it on our own :(
			d ($e->getAsString());
		}

		$sFragment	= '';
		if ($sUrl == null) {
			$iQPos = strpos($_SERVER['REQUEST_URI'], '?');
			if ($iQPos) {
				$sPath		= substr ($_SERVER['REQUEST_URI'], 0 , $iQPos);
				$sQuery		= substr ($_SERVER['REQUEST_URI'], $iQPos+1);
			} else {
				$sPath		= $_SERVER['REQUEST_URI'];
			}
			if (stristr($_SERVER['REQUEST_URI'], '#')) {
				$sFragment	= substr ($_SERVER['REQUEST_URI'], strpos($_SERVER['REQUEST_URI'],'#'));
			}
		} else {
			$iQPos = strpos($sUrl, '?');
			if ($iQPos) {
				$sPath		= substr ($sUrl, 0 , $iQPos);
				$sQuery		= substr ($sUrl, $iQPos + 1);
			} else {
				//
			}
			if (stristr($sUrl, '#')) {
				$sFragment	= substr ($sUrl, strpos('#'));
			}
		}

		$aComponents['path']		= $sPath;
		$aComponents['query']		= $sQuery;
		$aComponents['fragment']	= $sFragment;

		switch ($iComponent) {
		case -1:
			return $aComponents;
			break;
		case PHP_URL_SCHEME:
			return $aComponents['scheme'];
			break;
		case PHP_URL_USER:
			return $aComponents['user'];
			break;
		case PHP_URL_PASS:
			return $aComponents['pass'];
			break;
		case PHP_URL_HOST:
			return $aComponents['host'];
			break;
		case PHP_URL_PORT:
			return $aComponents['port'];
			break;
		case PHP_URL_PATH:
			return $aComponents['path'];
			break;
		case PHP_URL_QUERY:
			return $aComponents['query'];
			break;
		case PHP_URL_FRAGMENT:
			return $aComponents['fragment'];
			break;
		}
	}

	public function setUrl ($sUrl) {
		$this->sUrl 		= $sUrl;
		$this->aComponents  = self::parseUrl ($sUrl);
	}

	public function getScheme () {
		return $this->aComponents['scheme'];
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

	public function getHost () {
		return $this->aComponents['host'];
	}

	static public function pathHasFile($sPath) {
		return (bool)stristr(substr ($sPath, strrpos($sPath, '/')), '.');
	}

	static public function pathRemoveFile($sPath) {
		return substr ($sPath,0, strrpos($sPath, '/') + 1); // +1, because I need to keep the trailing /
	}

	/**
	 * @return string
	 */
	public function getCurrentPath () {
		$sCurrentPath = self::parseUrl($_SERVER['REQUEST_URI'], PHP_URL_PATH);
		if (self::pathHasFile ($sCurrentPath)) {
			return self::pathRemoveFile ($sCurrentPath);
		}
	}

	public function getPath () {
		$sPath = $this->aComponents['path'];

		if (!self::isAbsolutePath($sPath)) {
			if (substr ($sPath, 0, 2) == './'){
				$sPath = substr ($sPath, 2);
			}
			$sPath = $this->getCurrentPath() . $sPath;
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
			}
		}

		$sPath = (count($aPath) > 0 ?  '/' . implode ('/', $aPath) : '');
		$sLast = end ($aPath);
		if (!stristr($sLast, '.')) { // we don't have a file as the last element in the path
			$sPath .= '/';
		}
		return $sPath;
	}

	/**
	 * @param string $sPath
	 * @return vscUrlParserA
	 */
	public function addPath ($sPath) {
		$aRet = self::parseUrl($sPath);
		if (self::isAbsolutePath($sPath)) {
			$this->aComponents['path'] = $aRet['path'];
		} else {
			$this->aComponents['path'] .= $aRet['path'];
		}
		if (!self::hasGoodTermination($this->aComponents['path']))
			$this->aComponents['path'] .= '/';
		return $this;
	}

	static public function hasGoodTermination ($sUri) {
		if (!$sUri)
			return false;
		// a correct uri either ends in a / or with a file-name: name.ext
		return (substr($sUri, -1) == '/' || stristr(substr ($sUri, strrpos($sUri, '/')), '.'));
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

	public function getFragment () {
		return $this->aComponents['fragment'];
	}

	public function getUrl () {
		return $this->sUrl;
	}

	public static function isAbsolutePath ($sPath) {
		return (substr ($sPath, 0, 1) == '/');
	}

	public function getCompleteUri ($bFull = false) {
		$sUrl = '';

		if ($bFull) {
			$sScheme = $this->getScheme();
			if (!$sScheme) {
				$sScheme = 'http';
			}
			$sUrl =  $sScheme. '://';

			$sUser = $this->getUser();
			if ($sUser) {
				$sPass 	= $this->getPass();
				$sUrl 	.=  $this->getUser() . ($sPass ? ':' . $sPass : '') . '@';
			}

			$sHost = $this->getHost();
			if (!$sHost) {
				$sHost = $_SERVER['HTTP_HOST'];
			}

			$sUrl .= $sHost;
		}

		$sUrl .= $this->getPath();

		$sQuery = $this->getQuery ();
		if ($sQuery) {
			$sUrl .= '?' . $sQuery;
		}
		$sFragment = $this->getFragment();
		if ($sFragment) {
			$sUrl .= '#' . $sFragment;
		}
		return $sUrl;
	}
}
