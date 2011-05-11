<?php
/**
 * @package vsc_presentation
 * @subpackage responses
 * @author marius orcsik <marius@habarnam.ro>
 * @date 2011.02.23
 */

class vscHttpGenericResponse extends vscHttpResponseA {
	public function getOutput () {
		$this->setTransferEncoding('identity');
		$this->setContentLength(mb_strlen($this->sResponseBody, '8bit')); // getting the length in bytes - not characters

		$this->outputHeaders ();

		return $this->sResponseBody;
	}
}