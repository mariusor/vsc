<?php
/**
 * @package vsc_application
 * @subpackage sitemaps
 * @author marius orcisk <marius@habarnam.ro>
 * @date 2011.11.20
 */

class vscErrorMap extends vscProcessorMap {
	public function __construct () {
		parent::__construct(VSC_RES_PATH . 'application/processors/vscerrorprocessor.class.php' , '\A.*\Z');
	}
}