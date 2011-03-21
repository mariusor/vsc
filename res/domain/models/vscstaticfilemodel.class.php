<?php
/**
 * @package vsc_application
 * @subpackage controllers
 * @author marius orcsik <marius@habarnam.ro>
 * @date 2011.02.21
 */
class vscStaticFileModel extends vscModelA {
	protected $sFilePath;
	protected $sFileContent;
	protected $iMTime;

	public function setFilePath ($sPath) {
		$this->sFilePath = $sPath;
		$this->setMTime(filemtime($this->getFilePath()));
	}

	public function getFilePath () {
		return $this->sFilePath;
	}

	public function setFileContent ($sContent) {
		$this->sFileContent = $sContent;
	}

	public function getFileContent () {
		if (is_null($this->sFileContent)) {
			$this->sFileContent = file_get_contents($this->getFilePath());
		}
		return $this->sFileContent;
	}

	public function setMTime ($iMTime) {
		$this->iMTime = $iMTime;
	}

	public function getMTime () {
		return $this->iMTime;
	}
}