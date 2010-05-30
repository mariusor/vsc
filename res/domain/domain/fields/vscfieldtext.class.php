<?php
/**
 * @package vsc_domain
 * @subpackage domain
 * @author Marius Orcsik <marius@habarnam.ro>
 * @date 09.05.01
 */
import (VSC_LIB_PATH . 'domain/domain/fields');

class vscFieldText extends vscFieldA {
	protected  $maxLength = 255;
	protected  $encoding = 'UTF8';

	public function getType () {
		return vscFieldType::TEXT;
	}

	protected function escape () {
		// need a mechanism based on the connection type
		// TODO
		return $this->value;
	}

	public function getEncoding () {
		return $this->encoding;
	}

	public function setEncoding ($sEncoding) {
		$this->encoding = $sEncoding;
	}

}
