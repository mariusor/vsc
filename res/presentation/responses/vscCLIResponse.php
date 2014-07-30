<?php
/**
 * @package vsc_presentation
 * @subpackage responses
 * @author marius orcsik <marius@habarnam.ro>
 * @date 2011.02.23
 */
namespace vsc\presentation\responses;

class vscCLIResponse extends vscResponseA {
	public function getOutput () {
		$sBody = parent::getOutput();

		return $sBody;
	}
}
