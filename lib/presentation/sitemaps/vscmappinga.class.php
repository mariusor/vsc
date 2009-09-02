<?php
abstract class vscMappingA {
	private $sRegexUrl;
	private $sPath;
	private $sName;

	public function __construct ($sRegex, $sPath) {
		$this->setUrl ($sRegex);
		$this->setPath ($sPath);
	}

	public function getUrl () {
		return $this->sRegexUrl;
	}

	public function getPath () {
		return $this->sPath  . DIRECTORY_SEPARATOR;
	}

	public function getName () {
		return $this->sName;
	}

	public function setUrl ($sUrl) {
		$this->sRegexUrl = $sUrl;
	}

	public function setPath ($sPath) {
		$this->sPath = realpath($sPath);
	}

	public function setName ($sName) {
		$this->sName = $sName;
	}

	abstract public function isModule ();
}