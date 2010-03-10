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

	static private function parse_url ($sUrl = null) {
		$sFragment	= '';
		if ($sUrl) {
			$iQPos = strpos($_SERVER['REQUEST_URI'], '?');
			$sPath		= substr ($_SERVER['REQUEST_URI'], 0 , $iQPos);
			$sQuery		= substr ($_SERVER['REQUEST_URI'], $iQPos);
			if (stristr($_SERVER['REQUEST_URI'], '#')) {
				$sFragment	= substr ($_SERVER['REQUEST_URI'], strpos($_SERVER['REQUEST_URI'],'#'));
			}
		} else {
			$sPath		= substr ($sUrl, 0 , strpos('?'));
			$sQuery		= substr ($sUrl, strpos('?'));
			if (stristr($sUrl, '#')) {
				$sFragment	= substr ($sUrl, strpos('#'));
			}
		}

		return array (
			'scheme'	=> (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? 'https' : 'http'),
			'host'		=> ($_SERVER['SERVER_NAME']),
			'user'		=> '',
			'pass'		=> '',
			'path'		=> $sPath,
			'query'		=> $sQuery,
			'fragment'	=> $sFragment
		);
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
            $this->aComponents  = self::parse_url ($sUrl);
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

		$sPath = (count($aPath) > 0 ?  '/' . implode ('/', $aPath) : ''). '/';
		return $sPath;
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
