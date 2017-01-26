<?php
/**
 * @author Marius Orcsik <marius@habarnam.ro>
 * @created 2015-07-03
 */
namespace vsc\infrastructure\urls;

use vsc\infrastructure\Object;

class Url extends Object
{
	static protected $queryEncodingType = PHP_QUERY_RFC1738;
	static protected $validSchemes = ['http', 'https', 'file'];

	/**
	 * @var string
	 */
	private $scheme;
	/**
	 * @var string
	 */
	private $host;
	/**
	 * @var int
	 */
	private $port;
	/**
	 * @var string
	 */
	private $path;
	/**
	 * @var array
	 */
	private $query = [];
	/**
	 * @var string
	 */
	private $fragment;

	public function __toString() {
		return $this->getUrl();
	}

	/**
	 * @param string $scheme
	 */
	public function setScheme($scheme) {
		if (static::isValidScheme($scheme)) {
			$this->scheme = $scheme;
		}
	}

	/**
	 * @param string $host
	 */
	public function setHost($host) {
		$this->host = $host;
	}

	/**
	 * @param int $port
	 */
	public function setPort($port) {
		$this->port = $port;
	}

	/**
	 * @param string $path
	 */
	public function setPath($path) {
		$this->path = $path;
	}
	/**
	 * @param [] $query
	 */
	public function setQuery($query) {
		$this->query = $query;
	}
	/**
	 * @param string $query
	 */
	public function setRawQuery($query) {
		parse_str($query, $this->query);
	}

	/**
	 * @param string $fragment
	 */
	public function setFragment($fragment) {
		$this->fragment = $fragment;
	}

	/**
	 * @return string
	 */
	public function getScheme() {
		return $this->scheme;
	}

	/**
	 * @return string
	 */
	public function getHost() {
		return $this->host;
	}

	/**
	 * @return int
	 */
	public function getPort() {
		return $this->port;
	}

	/**
	 * @return string
	 */
	public function getPath() {
		return UrlParserA::normalizePath($this->path);
	}

	/**
	 * @return array
	 */
	public function getQuery() {
		return $this->query;
	}

	/**
	 * @param bool $encoded
	 * @return string
	 */
	public function getRawQueryString($encoded = true) {
		return http_build_query($this->getQuery(), '', $encoded ? '&amp;' : '&', static::$queryEncodingType);
	}

	/**
	 * @return string
	 */
	public function getFragment() {
		return $this->fragment;
	}

	/**
	 * @param string $schema
	 * @return bool
	 */
	static public function isValidScheme($schema) {
		return in_array($schema, static::$validSchemes);
	}

	/**
	 * @return bool
	 */
	public function hasScheme() {
		return static::isValidScheme($this->scheme);
	}

	/**
	 * @return bool
	 */
	public function hasHost() {
		return (null !== $this->host);
	}

	/**
	 * @return bool
	 */
	public function hasPort() {
		return (null !== $this->port);
	}

	/**
	 * @return bool
	 */
	public function hasPath() {
		return !empty($this->path);
	}

	/**
	 * @return bool
	 */
	public function hasQuery() {
		return count($this->query) > 0;
	}

	/**
	 * @return bool
	 */
	public function hasFragment() {
		return (null !== $this->fragment);
	}

	/**
	 * @return bool
	 */
	public function isLocal() {
		return (($this->getScheme() == 'file' || !$this->hasScheme()) && !$this->hasHost() && $this->hasPath());
	}

	/**
	 * @return string
	 */
	public function getUrl() {
		$rawUrl = '';
		if ($this->hasScheme() && $this->hasHost()) {
			$rawUrl .= $this->getScheme() . '://';
		}
		if ($this->hasHost()) {
			$rawUrl .= $this->getHost();
		}
		if ($this->hasPort() && $this->getPort() != 80) {
			$rawUrl .= ':' . $this->getPort();
		}
		if ($this->hasPath()) {
			// this needs normalization
			$rawUrl .= $this->getPath();
		}
		if (!empty($rawUrl) && !UrlParserA::hasGoodTermination($rawUrl)) {
			$rawUrl .= '/';
		}
		if ($this->hasQuery()) {
			$rawUrl .= '?' . $this->getRawQueryString();
		}
		if ($this->hasFragment()) {
			$rawUrl .= '#' . $this->getFragment();
		}

		return $rawUrl;
	}

	/**
	 * @param string $sPath
	 * @returns UrlParserA
	 */
	public function addPath($sPath) {
		$sExistingPath = $this->getPath();
		if (substr($sExistingPath, -1) != '/') {
			$sPath = '/' . $sPath;
		}
		$this->setPath($sExistingPath . $sPath);
		return $this;
	}

}
