<?php
/**
 * @package vsc\res\application
 * @subpackage controllers
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.08.31
 */
namespace vsc\application\controllers;

use \vsc\presentation\views\XhtmlView;

class XhtmlController extends CacheableControllerA implements HtmlControllerI {
	public function getDefaultView () {
		return new XhtmlView();
	}
}
