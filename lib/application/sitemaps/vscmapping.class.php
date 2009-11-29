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

//	public function __toString () {
//		return $this->getPath();
//	}
}