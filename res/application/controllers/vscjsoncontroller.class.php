<?php
/**
 * @package vsc_res_application
 * @subpackage controllers
 * @author marius orcsik <marius@habarnam.ro>
 * @date 10.04.09
 */
import ('presentation/views');
import ('application/controllers');
class vscJsonController extends vscFrontControllerA implements vscJsonControllerI {
	public function getDefaultView () {
		return new vscJsonView();
	}
}