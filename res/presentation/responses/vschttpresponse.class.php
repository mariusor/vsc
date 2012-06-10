<?php
/**
 * @package vsc_presentation
 * @subpackage responses
 * @author marius orcsik <marius@habarnam.ro>
 * @date 2011.02.23
 */

class vscHttpResponse extends vscHttpResponseA {
	public function getOutput () {
		$sBody = parent::getOutput();

		$this->outputHeaders ();

		return $sBody;
	}
}