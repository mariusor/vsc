<?php
namespace vsc;

class Exception extends \Exception {
	static public function isValid ($e) {
		return ($e instanceof static);
	}
}
