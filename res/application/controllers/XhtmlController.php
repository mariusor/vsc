<?php
/**
 * @package vsc\res\application
 * @subpackage controllers
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.08.31
 */
namespace vsc\application\controllers;

use \vsc\presentation\views\XhtmlView;

// \vsc\import ('presentation/views');
// \vsc\import ('application/controllers');
// \vsc\import ('presentation');
// \vsc\import ('views');

class XhtmlController extends CacheableControllerA implements XhtmlControllerI {
	public function getDefaultView () {
		return new XhtmlView();
	}
}
