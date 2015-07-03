<?php
/**
 * @author Marius Orcsik <marius.orcsik@rocket-internet.de>
 * @copyright Copyright (c) 2015 Rocket Internet SE, Johannisstraße 20, 10117 Berlin, http://www.rocket-internet.de
 * @created 2015-07-03
 */
namespace vsc\infrastructure\urls;

use vsc\infrastructure\Object;

class Url extends Object
{
	static protected $QUERY_ENCODING_TYPE = PHP_QUERY_RFC3986;
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
//	private $user;
//	private $pass;
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

	/**
	 * @param string $scheme
	 */
	public function setScheme($scheme) {
		if (static::isValidScheme($scheme)) {
			$this->scheme =  $scheme;
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
		return $this->path;
	}

	/**
	 * @return array
	 */
	public function getQuery() {
		return $this->query;
	}

	/**
	 * @return string
	 */
	public function getRawQueryString() {
		return http_build_query($this->getQuery(), '', '&', static::$QUERY_ENCODING_TYPE);
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
	static public function isValidScheme ($schema) {
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
		return (null !== $this->path);
	}

	/**
	 * @return bool
	 */
	public function hasQuery() {
		return count($this->query)>0;
	}

	/**
	 * @return bool
	 */
	public function hasFragment() {
		return (null !== $this->fragment);
	}

	/**
	 * @return string
	 */
	protected function getUrl() {
		$rawUrl = '';
		if ($this->hasScheme()) {
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
		if ($this->hasQuery()) {
			$rawUrl .= $this->getRawQueryString();
		}
		if ($this->hasFragment()) {
			$rawUrl .= '#' . $this->getFragment();
		}

		return $rawUrl;
	}
}
