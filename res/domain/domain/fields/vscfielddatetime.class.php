<?php
/**
 * @package vsc_domain
 * @subpackage domain
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.05.01
 */

import (VSC_LIB_PATH . 'domain/domain/fields');

class vscFieldDateTime extends vscFieldA {
	protected  $maxLength = null; // arbitrary chosen, > strlen(YYYY-MM-DD GG:II:SS)

	public function getType () {
		return vscFieldType::DATETIME;
	}

	protected function escape () {
		// need a mechanism based on the connection type
		// TODO
		return $this->value;
	}

	public function format ($sFormat) {
		return static::parse ($sFormat, $this->value);
	}

	static public function parse ($mValue, $sFormat = '%Y-%m-%d %T') {
		if (is_string($mValue))
			$mValue = strtotime($mValue);

		return strftime($sFormat, $mValue);
	}

}
