<?php
/**
 * @package vsc_presentation
 * @subpackage responses
 * @author marius orcsik <marius@habarnam.ro>
 * @date 2011.02.23
 */

class vscCLIResponse extends vscResponseA {
	public function getOutput () {
		$sBody = parent::getOutput();

		return $sBody;
	}
}
