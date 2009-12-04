<?php
/**
 * @package vsc_res_application
 * @subpackage controllers
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.08.31
 */
import ('application/presentation/views');
import ('application/controllers');
class vscXhtmlController extends vscFrontControllerA  implements vscXhtmlControllerI {
	public function getDefaultView () {
		return new vscXhtmlView();
	}
}