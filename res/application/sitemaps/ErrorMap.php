<?php
/**
 * @package application
 * @subpackage sitemaps
 * @author marius orcisk <marius@habarnam.ro>
 * @date 2011.11.20
 */
namespace vsc\application\sitemaps;

class ErrorMap extends ProcessorMap {
	public function __construct () {
		parent::__construct('\\vsc\\application\\processors\\ErrorProcessor' , '\A.*\Z');
	}
}
