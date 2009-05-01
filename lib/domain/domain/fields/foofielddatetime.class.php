<?php
/**
 * @package ts_models
 * @author Marius Orcsik <marius@habarnam.ro>
 * @date 09.05.01
 */
class fooFieldDateTime extends fooFieldA {
	const TYPE = 'datetime';
	protected  $maxLength = 20; // arbitrary chosen, > strlen(YYYY-MM-DD GG:II:SS)

	public function isVarChar (fooFieldA $oField) {
		return ($oField instanceof self);
	}

	public function getType () {
		return self::TYPE;
	}

	protected function escape () {
		// need a mechanism based on the connection type
		// TODO
		return $this->value;
	}
}