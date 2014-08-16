<?php
/**
 * @package application
 * @subpackage sitemaps
 * @author marius orcisk <marius@habarnam.ro>
 * @date 2011.11.20
 */
namespace vsc\application\sitemaps;

class ErrorControllerMap extends ControllerMap {
	public function __construct () {
		parent::__construct('\\vsc\\application\\controllers\\Html5Controller' , '\A.*\Z');
	}
}
