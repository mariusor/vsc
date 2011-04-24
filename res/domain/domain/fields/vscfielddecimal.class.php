<?php
class vscFieldDecimal extends vscFieldInteger {
	private $iDecimals = 3;

	public function __construct ($sName, $iLength, $iDecimals) {
		$this->setMaxLength($iLength);
		$this->setDecimals($iDecimals);

		parent::__construct($sName);
	}

	public function getDecimals () {
		return $this->iDecimals;
	}
	public function setDecimals ($iDecimals) {
		$this->iDecimals = $iDecimals;
	}

	public function getType () {
		return vscFieldType::DECIMAL;
	}
}