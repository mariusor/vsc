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
		return $this->getCompleteUrl(true);
	}

	public function setUrl ($sUrl) {
		$this->sUrl 		= $sUrl;
        try {
            $this->aComponents  = array_merge (array (
                'scheme'	=> '',
                'host'		=> '',
                'user'		=> '',
                'pass'		=> '',
                'path'		=> '',
                'query'		=> '',
                'fragment'	=> ''
            ), parse_url($sUrl));
        } catch (vscExceptionError $e) {
            // d ($e);
        }
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

	public function getPath () {
		$sPath = $this->aComponents['path'];

		if (!self::isAbsolutePath($sPath)) {
			if (substr ($sPath, 0, 2) == './'){
				$sPath = substr ($sPath, 2);
			}
			try {
                $sParentPath = substr (parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), 0 , -1) . '/';
            } catch (vscExceptionError $e) {
                //
                $sParentPath = '';
            }
            $sPath = $sParentPath . $sPath;
		}

		// removing the folders from the path if there are parent references (../)
		$sPath = trim($sPath, '/');
		$tPath = explode('/', $sPath);
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

//				if ($iCnt == 3) d ($tPath, array($iPrevKey=>$sPrev), array($iKey=>$sFolder));
			}
		}

		$sPath = '/' . implode ('/', $aPath) . '/';
		return $sPath;
	}

	/**
	 * @param string $sPath
	 * @return vscUrlParserA
	 */
	public function addPath ($sPath) {
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

	public function getFragment () {
		return $this->aComponents['fragment'];
	}

	public function getUrl () {
		return $this->sUrl;
	}

	public function isLocal () {
		return (!$this->getScheme() && $this->getPath());
	}

	public static function isAbsolutePath ($sPath) {
		return substr ($sPath, 0, 1) == '/';
	}

	public function getCompleteUrl ($bFull = false) {
		if (!$this->isLocal()) {
			$bFull = true;
		}
		$sUrl = '';

		if ($bFull) {
			$sScheme = $this->getScheme();
			if (!$sScheme) {
				$sScheme = 'http';
			}
			$sUrl .=  $sScheme. '://';

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

		$sPath = $this->getPath();
		if (self::isAbsolutePath($sPath)) {
			$sUrl .= $sPath;
		} else {
			try {
				$sUrl .= parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) . $sPath;
			} catch (vscExceptionError $e) {
				d ($e->getTraceAsString());
			}
		}

		if (substr($sPath, -1) != '/') {
			$sPath .= '/';
		}

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
