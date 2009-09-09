<?php
class vscMappingModule extends vscMappingA {
	private $sParentName;

	public function setParent ($sName) {
		$this->sParentName = $sName;
	}

	public function getParent () {
		return $this->sParentName;
	}

	public function getConfigDir () {
		return $this->getPath() . 'config' . DIRECTORY_SEPARATOR;
	}

	public function getConfigMap () {
		return $this->getConfigDir() . 'map.php';
	}

	public function hasMap () {
		return (
			is_dir ($this->getConfigDir ()) &&
			is_file ($this->getConfigMap())
		);
	}

	public function isModule () {
		return $this->hasMap();
	}

	public function getProcessorPath () {
		return $this->getPath() . 'processors' . DIRECTORY_SEPARATOR;
	}
}