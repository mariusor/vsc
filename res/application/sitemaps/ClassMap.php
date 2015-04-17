<?php
/**
 * @package vsc\application\sitemaps
 * @author marius orcisk <marius@habarnam.ro>
 * @date 2014.08.07
 */
namespace vsc\application\sitemaps;

use vsc\infrastructure\Object;

class ClassMap extends MappingA implements ContentTypeMappingI {
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
