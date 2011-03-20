<?php
/**
 * @package vsc_presentation
 * @subpackage responses
 * @author marius orcsik <marius@habarnam.ro>
 * @date 11.02.23
 */

class vscHttpGenericResponse extends vscHttpResponseA {
	public function getOutput () {
		if (
			$this->getStatus() == 204 ||
			$this->getStatus() == 304
		) {
			//header("Connection: close");
			// I still have no fracking clue if this works
			$this->sResponseBody = null;
			$this->setContentLength(0);
		};

		$this->outputHeaders ();

		return $this->sResponseBody;
	}
}