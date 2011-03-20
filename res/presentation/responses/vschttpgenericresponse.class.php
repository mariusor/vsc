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
			$this->getContentLength() == 0
		) {
			// I still have no fracking clue if this works
			$this->sResponseBody = null;
		};

		$this->outputHeaders ();

		return $this->sResponseBody;
	}
}