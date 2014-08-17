<?php
/**
 * @package res_application
 * @subpackage controllers
 * @author marius orcsik <marius@habarnam.ro>
 * @date 2010.04.09
 */
namespace vsc\application\controllers;

use \vsc\presentation\views\PlainTextView;

class PlainTextController extends CacheableControllerA implements PlainTextControllerI {
	public function getDefaultView () {
		return new PlainTextView();
	}
}
