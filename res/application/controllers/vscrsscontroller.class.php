<?php
/**
 * @package vsc_res_application
 * @subpackage controllers
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.08.31
 */
import ('presentation/views');
import ('application/controllers');
class vscRssController extends vscCacheableControllerA implements vscRssControllerI {
	public function getDefaultView () {
		return new vscRssView();
	}
}