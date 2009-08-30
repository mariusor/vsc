<?php
/**
 * @package vsc_controllers
 * @subpackage vsc_controllers
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.08.30
 */
class vscFrontController {
	/**
	 *
	 * @return vscHttpResponseA
	 */
	public function dispatch () {
		import ('controllers/responses');
		return new vscHttpSuccess();
	}
}