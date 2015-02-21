<?php
/**
 * @package application
 * @subpackage sitemaps
 * @author marius orcisk <marius@habarnam.ro>
 * @date 2011.11.20
 */
namespace vsc\application\sitemaps;

use vsc\application\processors\ErrorProcessor;

class ErrorMap extends ProcessorMap {
	public function __construct() {
		parent::__construct(ErrorProcessor::class, '\A.*\Z');
	}
}
