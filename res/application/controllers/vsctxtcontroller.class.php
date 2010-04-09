<?php
/**
 * @package vsc_res_application
 * @subpackage controllers
 * @author marius orcsik <marius@habarnam.ro>
 * @date 10.04.09
 */
import ('application/presentation/views');
import ('application/controllers');
class vscTxtController extends vscFrontControllerA {
	public function getDefaultView () {
		return new vscTxtView();
	}
}