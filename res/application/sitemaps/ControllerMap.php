<?php
/**
 * @package application
 * @subpackage sitemaps
 * @author marius orcisk <marius@habarnam.ro>
 * @date 2010.12.05
 */
namespace vsc\application\sitemaps;

use vsc\ExceptionPath;
use vsc\infrastructure\vsc;
use vsc\presentation\views\ViewA;

class ControllerMap extends MappingA implements ContentTypeMappingI {
	use ControllerMapT;
}
