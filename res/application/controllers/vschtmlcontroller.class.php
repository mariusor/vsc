<?php
/**
 * @package vsc_presentation
 * @subpackage controllers
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.08.31
 */

import ('presentation/views');
import ('application/controllers');
class vscHtmlController extends vscFrontControllerA {
	public function getDefaultView () {
		return new vscXhtmlView();
	}
}