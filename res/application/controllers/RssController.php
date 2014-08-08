<?php
/**
 * @package res_application
 * @subpackage controllers
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.08.31
 */
namespace vsc\application\controllers;

use \vsc\presentation\views\RssView;

// \vsc\import ('presentation/views');
// \vsc\import ('application/controllers');
class RssController extends CacheableControllerA implements RssControllerI {
	public function getDefaultView () {
		return new RssView();
	}
}
