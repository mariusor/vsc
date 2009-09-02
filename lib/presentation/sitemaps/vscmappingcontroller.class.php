<?php
class vscMappingController extends vscMappingA {
	public function getPath () {
		return substr(parent::getPath(), 0, -1);
	}

	public function getInstance ($aParameters) {
		include ($this->getPath());
		$sName = $this->getName();

		return new $sName ($aParameters);
	}

	public function isModule () {
		return false;
	}
}