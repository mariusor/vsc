<?php
/**
 * @package vsc_exceptions
 * @author marois orcsik <marius@habarnam.ro>
 * @date 09.08.30
 */
class vscExceptionPath extends vscException {
	public function getPath () {
		return get_include_path();
	}

	public function getPathAsArray () {
		return explode(':', $this->getPath());
	}
}