<?php
/**
 * @package application
 * @subpackage sitemaps
 * @author marius orcisk <marius@habarnam.ro>
 * @date 2011.11.20
 */
namespace vsc\application\sitemaps;

use vsc\application\processors\ErrorProcessor;

class ErrorProcessorMap extends ClassMap {
	public function __construct($sPath = null) {
		if (is_null($sPath)) {
			$sPath = ErrorProcessor::class;
		}
		parent::__construct($sPath, '\A.*\Z');
	}
}
