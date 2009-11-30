<?php
class vscMapping {
	private $sRegex;
	private $sProcessorPath;

	private $sViewPath;

	private $sTitle;
	private $aResources;

	private $sMainTemplate;

	public function __construct ($sPath, $sRegex) {
		$this->sProcessorPath	= $sPath;
		$this->sRegex			= $sRegex;
	}

	public function setTitle ($sTitle) {
		$this->sTitle = $sTitle;
	}

	public function setTemplate ($sPath) {
		$this->sMainTemplate = $sPath;
	}

	public function getTemplate () {
		return $this->sMainTemplate;
	}

	public function getPath () {
		return $this->sProcessorPath;
	}

	public function addStyle ($sPath) {
		$this->aResources['styles'][] = $sPath;
	}

	public function addScript ($sPath) {
		$this->aResources['scripts'][] = $sPath;
	}

	public function addMeta ($sName, $sValue) {
		$this->aResources['headers'][$sName] = $sValue;
	}
}