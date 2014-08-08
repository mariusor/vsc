<?php
/**
 * @package res_application
 * @subpackage controllers
 * @author marius orcsik <marius@habarnam.ro>
 * @date 2010.04.09
 */
namespace vsc\application\controllers;

use \vsc\presentation\views\JsonView;

// \vsc\import ('presentation/views');
// \vsc\import ('application/controllers');
class JsonController extends CacheableControllerA implements JsonControllerI {
	public function getDefaultView () {
		return new JsonView();
	}
}
