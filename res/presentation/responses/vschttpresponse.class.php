<?php
/**
 * @package vsc_presentation
 * @subpackage responses
 * @author marius orcsik <marius@habarnam.ro>
 * @date 2011.02.23
 */
namespace vsc\presentation\requests;

class vscHttpResponse extends vscHttpResponseA {
	public function getOutput () {
		$sBody = parent::getOutput();

		$this->outputHeaders ();

		return $sBody;
	}
}