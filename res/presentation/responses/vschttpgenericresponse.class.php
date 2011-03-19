<?php
/**
 * @package vsc_presentation
 * @subpackage responses
 * @author marius orcsik <marius@habarnam.ro>
 * @date 11.02.23
 */

class vscHttpGenericResponse extends vscHttpResponseA {
	public function getOutput () {
		$this->outputHeaders ();
		if (
			$this->getStatus() == 204 ||
			$this->getStatus() == 304
		) {
			$this->sResponseBody = null;
			$this->setContentLength(0);
		};

		return $this->sResponseBody;
	}
}