<?php
/**
 * @package res_presentation
 * @subpackage controllers
 * @author marius orcsik <marius@habarnam.ro>
 * @date 2010.10.15
 */
namespace vsc\application\controllers;

use \vsc\presentation\views\Html5View;

class Html5Controller extends XhtmlController implements HtmlControllerI {
	public function getDefaultView() {
		return new Html5View();
	}
}
