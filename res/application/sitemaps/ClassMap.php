<?php
/**
 * @package vsc\application\sitemaps
 * @author marius orcisk <marius@habarnam.ro>
 * @date 2014.08.07
 */
namespace vsc\application\sitemaps;

use vsc\application\processors\ProcessorA;
use vsc\ExceptionPath;
use vsc\infrastructure\Object;
use vsc\presentation\helpers\ViewHelperA;
use vsc\presentation\responses\HttpResponseA;
use vsc\presentation\responses\HttpResponseType;
use vsc\presentation\views\ViewA;

class ClassMap extends MappingA {
	use ProcessorMapT;
	use ControllerMapT;

	/**
	 * @param Object $MappedObject
	 * @return bool
	 */
	public function maps(Object $MappedObject)
	{
		return (get_class($MappedObject) == $this->getPath());
	}
}
