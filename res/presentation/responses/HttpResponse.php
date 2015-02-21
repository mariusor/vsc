<?php
/**
 * @package presentation
 * @subpackage responses
 * @author marius orcsik <marius@habarnam.ro>
 * @date 2011.02.23
 */
namespace vsc\presentation\responses;

class HttpResponse extends HttpResponseA {
	public function getOutput() {
		$sBody = parent::getOutput();

		$this->outputHeaders();

		return $sBody;
	}
}
