<?php
/**
 * @package vsc_application
 * @subpackage sitemaps
 * @author marius orcisk <marius@habarnam.ro>
 * @date 2011.11.20
 */

class vscErrorControllerMap extends vscControllerMap {
	public function __construct () {
		parent::__construct(VSC_RES_PATH . 'application/controllers/vschtml5controller.class.php' , '\A.*\Z');
	}
}