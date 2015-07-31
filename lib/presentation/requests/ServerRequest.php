<?php
/**
 * @package presentation
 * @subpackage requests
 * @author marius orcsik <marius@habarnam.ro>
 * @date 28.07.15
 */

namespace vsc\presentation\requests;

trait ServerRequest {
	/**
	 * @var string
	 */
	protected $sHttpMethod;
	/**
	 * @var string
	 */
	protected $sServerName;
	/**
	 * @var string
	 */
	protected $sServerProtocol;
	/**
	 * @var array
	 */
	protected $aAccept = [];
	/**
	 * @var array
	 */
	protected $aAcceptCharset = [];
	/**
	 * @var array
	 */
	protected $aAcceptEncoding	= [];
	/**
	 * @var array
	 */
	protected $aAcceptLanguage	= [];
	/**
	 * @var string
	 */
	protected $sReferer = '';
	/**
	 * @var string
	 */
	protected $sUserAgent = '';
	/**
	 * @var string
	 */
	protected $sIfModifiedSince = '';
	/**
	 * @var string
	 */
	protected $sIfNoneMatch		= '';
	/**
	 * @var string
	 */
	protected $sContentType		= '';
	/**
	 * @var bool
	 */
	protected $bDoNotTrack = false;
	/**
	 * @param HttpAuthenticationA $oHttpAuthentication
	 */
	abstract public function setAuthentication(HttpAuthenticationA $oHttpAuthentication);

	/**
	 * @return string
	 */
	public function getServerName() {
		return $this->sServerName;
	}
	/**
	 * @return string
	 */
	public function getServerProtocol() {
		return $this->sServerProtocol;
	}
	/**
	 * @return string
	 */
	public function getHttpMethod() {
		return $this->sHttpMethod;
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
	 * @return bool
	 */
	public function hasContentType() {
		return !empty($this->sContentType);
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
	 * @return bool
	 */
	public static function isSecure() {
		return (array_key_exists('HTTPS', $_SERVER) && $_SERVER['HTTPS'] == 'on');
	}

	private function loadServerHeaders($aServer) {
		if (isset ($aServer['SERVER_PROTOCOL'])) {
			$this->sServerProtocol = $aServer['SERVER_PROTOCOL'];
		}
		if (isset ($aServer['SERVER_NAME'])) {
			$this->sServerName = $aServer['SERVER_NAME'];
		}
	}

	private function loadAcceptHeaders($aServer) {
		if (isset ($aServer['HTTP_ACCEPT'])) {
			$this->aAccept = explode(',', $aServer['HTTP_ACCEPT']);
		}
		if (isset ($aServer['HTTP_ACCEPT_LANGUAGE'])) {
			$this->aAcceptLanguage = explode(',', $aServer['HTTP_ACCEPT_LANGUAGE']);
			foreach ($this->aAcceptLanguage as $index => $value) {
				$this->aAcceptLanguage[$index] = trim($value);
			}
		}
		if (isset ($aServer['HTTP_ACCEPT_ENCODING'])) {
			$this->aAcceptEncoding = explode(',', $aServer['HTTP_ACCEPT_ENCODING']);
			foreach ($this->aAcceptEncoding as $index => $value) {
				$this->aAcceptEncoding[$index] = trim($value);
			}
		}
		if (isset ($aServer['HTTP_ACCEPT_CHARSET'])) {
			$this->aAcceptCharset = explode(',', $aServer['HTTP_ACCEPT_CHARSET']);
			foreach ($this->aAcceptCharset as $index => $value) {
				$this->aAcceptCharset[$index] = trim($value);
			}
		}
	}

	private function loadCachingHeaders($aServer) {
		if (isset($aServer['HTTP_IF_MODIFIED_SINCE'])) {
			$this->sIfModifiedSince = $aServer['HTTP_IF_MODIFIED_SINCE'];
		}
		if (isset($aServer['HTTP_IF_NONE_MATCH'])) {
			$this->sIfNoneMatch = $aServer['HTTP_IF_NONE_MATCH'];
		}
	}

	private function loadAuthenticationHeaders($aServer) {
		if (isset($aServer['PHP_AUTH_DIGEST'])) {
			// DIGEST authorization attempt
			$this->setAuthentication(new DigestHttpAuthentication($aServer['PHP_AUTH_DIGEST'], $aServer['REQUEST_METHOD']));
		}
		if (isset($aServer['PHP_AUTH_USER']) && isset($aServer['PHP_AUTH_PW'])) {
			$this->setAuthentication(new BasicHttpAuthentication($aServer['PHP_AUTH_USER'], $aServer['PHP_AUTH_PW']));
		}
	}

	/**
	 * @param $aServer
	 */
	public function initServer($aServer) {
		if (isset ($aServer['REQUEST_METHOD'])) {
			$this->sHttpMethod = $aServer['REQUEST_METHOD'];
		}

		$this->loadServerHeaders($aServer);
		$this->loadAcceptHeaders($aServer);
		$this->loadCachingHeaders($aServer);
		$this->loadAuthenticationHeaders($aServer);

		if (isset ($aServer['HTTP_USER_AGENT'])) {
			$this->sUserAgent = $aServer['HTTP_USER_AGENT'];
		}
		if (isset ($aServer['HTTP_REFERER'])) {
			$this->sReferer = $aServer['HTTP_REFERER'];
		}
		if (isset($aServer['CONTENT_TYPE'])) {
			if (stripos($aServer['CONTENT_TYPE'], ';') !== false) {
				$this->sContentType = substr($aServer['CONTENT_TYPE'], 0, stripos($aServer['CONTENT_TYPE'], ';'));
			} else {
				$this->sContentType = $aServer['CONTENT_TYPE'];
			}
		}

		if (isset($aServer['HTTP_DNT'])) {
			$this->bDoNotTrack = (bool)$aServer['HTTP_DNT'];
		}
	}
}
