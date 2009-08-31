<?php
/**
 * @package vsc_presentation
 * @subpackage controllers
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.08.30
 */
class vscFrontControllerA {
	/**
	 * @return vscHttpResponseA
	 */
	public function getResponse () {
		import ('presentation/responses');
		return new vscHttpSuccess();
	}
}