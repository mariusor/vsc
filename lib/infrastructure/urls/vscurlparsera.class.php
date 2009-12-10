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

	public function setUrl ($sUrl) {
		$this->sUrl 		= $sUrl;
		$this->aComponents  = array_merge (array (
			'scheme'	=> '',
			'host'		=> '',
			'user'		=> '',
			'pass'		=> '',
			'path'		=> '',
			'query'		=> '',
			'fragment'	=> ''
		), parse_url($sUrl));
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
			$iUp = substr_count ($sPath, '../');

			$sParentPath = substr (parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), 0 , -1);
			$aParent = array_slice (explode('/', $sParentPath), 0, -$iUp);

			$sPath = '/' . implode ('/', $aParent) . str_replace('../', '', $sPath);
		}
		return $sPath;
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
		return (substr ($sPath, 0, 1) == '/');
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
			$sUrl .= parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) . $sPath;
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