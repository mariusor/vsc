<?php
namespace vsc;

class Exception extends \Exception {
	public static function isValid($e) {
		return ($e instanceof static);
	}
}
