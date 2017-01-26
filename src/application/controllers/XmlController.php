<?php
/**
 * @package res_application
 * @subpackage controllers
 * @author marius orcsik <marius@habarnam.ro>
 * @date 2012.08.26
 */
namespace vsc\application\controllers;

use \vsc\presentation\views\XmlView;

class XmlController extends CacheableControllerA implements XmlControllerInterface {
	public function getDefaultView() {
		return new XmlView();
	}
}
