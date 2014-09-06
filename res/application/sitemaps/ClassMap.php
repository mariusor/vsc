<?php
/**
 * @package vsc\application\sitemaps
 * @author marius orcisk <marius@habarnam.ro>
 * @date 2014.08.07
 */
namespace vsc\application\sitemaps;

use vsc\application\processors\ProcessorA;
use vsc\ExceptionPath;
use vsc\presentation\helpers\ViewHelperA;
use vsc\presentation\responses\HttpResponseA;
use vsc\presentation\responses\HttpResponseType;
use vsc\presentation\views\ViewA;

class ClassMap extends MappingA {
	use ProcessorMapT;
	use ControllerMapT;
}
