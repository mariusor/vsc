<?php
/**
 * @package vsc_res_presentation
 * @subpackage controllers
 * @author marius orcsik <marius@habarnam.ro>
 * @date 2010.10.15
 */

import ('application/controllers');
import ('presentation/views');

class vscHtml5Controller extends vscXhtmlController {
	public function getDefaultView () {
		return new vscHtml5View();
	}
}