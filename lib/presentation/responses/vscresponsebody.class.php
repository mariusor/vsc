<?php
class vscResponseBody {
	private $sOutput;

	public function setOutput ($sText) {
		$this->sOutput = $sText;
	}

	public function getOutput () {
		return $this->sOutput;
	}
}