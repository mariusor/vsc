<?php
/**
 * @author Marius Orcsik <marius@habarnam.ro>
 * @created 2015-07-03
 */
namespace vsc\infrastructure\urls;

use vsc\infrastructure\BaseObject;

class Url extends BaseObject
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
		$schPos = strpos($host, '//');
		if ($schPos === false) {
			$this->host = $host;
		} else {
			$this->host = substr($host, $schPos+2);
		}
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
		if ($this->hasHost()) {
			if ($this->hasScheme()) {
				return $this->scheme . '://';
			}

			return '//';
		}
		return null;
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
		if ($this->hasPort() && $this->port != 80) {
			return ':' . $this->port;
		}
		return null;
	}

	/**
	 * @return string
	 */
	public function getPath() {
		$path = '';
		if ($this->hasPath()) {
			$path = UrlParserA::normalizePath($this->path);
		}
		if (($this->hasHost() || !empty($path))&& !UrlParserA::hasGoodTermination($path)) {
			$path .= '/';
		}
		return $path;
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
		if ($this->hasQuery()) {
			return '?' . http_build_query($this->getQuery(), '', $encoded ? '&amp;' : '&', static::$queryEncodingType);
		}
		return null;
	}

	/**
	 * @return string
	 */
	public function getFragment() {
		if ($this->hasFragment()) {
			return '#' . $this->fragment;
		}
		return null;
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
		return (null !== $this->host && !empty($this->host));
	}

	/**
	 * @return bool
	 */
	public function hasPort() {
		return (null !== $this->port && !empty($this->port));
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
		return (null !== $this->fragment && !empty($this->fragment));
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
		return $this->getScheme() .
			$this->getHost() .
			$this->getPort() .
			$this->getPath() .
			$this->getRawQueryString() .
			$this->getFragment();
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
