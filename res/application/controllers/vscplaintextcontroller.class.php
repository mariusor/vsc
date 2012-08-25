<?php
/**
 * @package vsc_res_application
 * @subpackage controllers
 * @author marius orcsik <marius@habarnam.ro>
 * @date 2010.04.09
 */
import ('presentation/views');
import ('application/controllers');
class vscPlainTextController extends vscCacheableControllerA implements vscPlainTextControllerI {
	public function getDefaultView () {
		return new vscPlainTextView();
	}
}