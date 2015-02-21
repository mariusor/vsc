<?php
/**
 * @package application
 * @subpackage controllers
 * @author marius orcsik <marius@habarnam.ro>
 * @date 2011.02.21
 */
namespace vsc\domain\models;

class StaticFileModel extends CacheableModelA {
	protected $sFilePath;
	protected $sFileContent;
	protected $sFileName;
	protected $iLastModified;

	public function setFilePath($sPath) {
		$this->sFilePath = $sPath;
		$this->setFileName(basename($sPath));
		$this->setLastModified(date('Y-m-d G:i:s', filemtime($this->getFilePath())));
	}

	public function getFilePath() {
		return $this->sFilePath;
	}

	public function setFileName($sName) {
		$this->sFileName = $sName;
	}

	public function getFileName() {
		return $this->sFileName;
	}

	public function setFileContent($sContent) {
		$this->sFileContent = $sContent;
	}

	public function getFileContent() {
		if (is_null($this->sFileContent)) {
			$this->sFileContent = file_get_contents($this->getFilePath());
		}
		return $this->sFileContent;
	}

	public function setLastModified($iMTime) {
		$this->iLastModified = $iMTime;
	}

	public function getLastModified() {
		return $this->iLastModified;
	}
}
