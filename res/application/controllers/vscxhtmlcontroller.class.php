<?php
/**
 * @package vsc_res_application
 * @subpackage controllers
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.08.31
 */
import ('application/controllers');
import ('presentation');
import ('views');
class vscXhtmlController extends vscCacheableControllerA implements vscXhtmlControllerI {
	public function getDefaultView () {
		return new vscXhtmlView();
	}
}
