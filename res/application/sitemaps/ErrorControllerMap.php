<?php
/**
 * @package application
 * @subpackage sitemaps
 * @author marius orcisk <marius@habarnam.ro>
 * @date 2011.11.20
 */
namespace vsc\application\sitemaps;

use vsc\application\controllers\Html5Controller;

class ErrorControllerMap extends ClassMap {
	public function __construct($sPath = null) {
		if (is_null($sPath)) {
			$sPath = Html5Controller::class;
		}
		parent::__construct($sPath, '\A.*\Z');
	}
}
