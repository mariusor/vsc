<?php
/**
 * @package exceptions
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.08.30
 */
namespace vsc;

class ExceptionPath extends Exception {
	public function getPath() {
		return get_include_path();
	}

	public function getPathAsArray() {
		return explode(PATH_SEPARATOR, $this->getPath());
	}
}
