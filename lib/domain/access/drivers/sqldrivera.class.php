<?php
abstract class sqlDriverA extends vscObject {
	public 	$STRING_OPEN_QUOTE,
			$STRING_CLOSE_QUOTE,
			$FIELD_OPEN_QUOTE,
			$FIELD_CLOSE_QUOTE,
			$TRUE,
			$FALSE;

	abstract public function _SELECT($incObj);

	abstract public function _DELETE($sIncName);

	abstract public function _CREATE($sIncName);

	abstract public function _SET();

	abstract public function _INSERT($incOb);

	abstract public function _VALUES ($incData);

	abstract public function _UPDATE($incOb);

	abstract public function _FROM($incData);

	abstract public function _AND();

	abstract public function _OR();

	abstract public function _JOIN ($type);

	abstract public function _AS($str);

	abstract public function _LIMIT($start, $end = 0);

	abstract public function _GROUP($incObj = null);

	abstract public function _ORDER($orderBys = null);

	abstract public function _WHERE ($clause);

	abstract public function _NULL ($bIsNull = true);
}