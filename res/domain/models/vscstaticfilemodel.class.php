<?php
/**
 * @package vsc_application
 * @subpackage controllers
 * @author marius orcsik <marius@habarnam.ro>
 * @date 2011.02.21
 */
class vscStaticFileModel extends vscCacheableModelA {
	protected $sFilePath;
	protected $sFileContent;
	protected $iLastModified;

	public function setFilePath ($sPath) {
		$this->sFilePath = $sPath;
		$this->setLastModified (date ('Y-m-d G:i:s', filemtime($this->getFilePath())));
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

	public function setLastModified ($iMTime) {
		$this->iLastModified = $iMTime;
	}

	public function getLastModified() {
		return $this->iLastModified;
	}
}