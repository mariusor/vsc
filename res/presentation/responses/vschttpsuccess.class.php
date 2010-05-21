<?php
/**
 * @package vsc_presentation
 * @subpackage responses
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.08.30
 */
class vscHttpSuccess extends vscHttpResponseA {
	protected $aStatusList = array (
		200 => '200 OK',
		204 => '204 No Content',
	);

	public function getOutput () {
		$this->outputHeaders ();
		return $this->sResponseBody;
	}
}