<?php
/**
 * @package vsc_res_application
 * @subpackage controllers
 * @author marius orcsik <marius@habarnam.ro>
 * @date 2012.08.26
 */
namespace vsc\application\controllers;

use \vsc\presentation\views\vscXmlView;

// \vsc\import ('presentation/views');
// \vsc\import ('application/controllers');

class vscXmlController extends vscCacheableControllerA implements vscXmlControllerI {
	public function getDefaultView () {
		return new vscXmlView();
	}
}