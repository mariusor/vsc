<?php
class vscException extends Exception {
	static public function isValid ($e) {
		return ($e instanceof static);
	}
}