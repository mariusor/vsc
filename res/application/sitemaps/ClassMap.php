<?php
/**
 * @package vsc\application\sitemaps
 * @author marius orcisk <marius@habarnam.ro>
 * @date 2014.08.07
 */
namespace vsc\application\sitemaps;

use vsc\infrastructure\Object as vscObject;

class ClassMap extends MappingA implements ContentTypeMappingI {
	use ProcessorMapT;
	use ControllerMapT;

	public static function isValidMap($sPath) {
		return class_exists($sPath);
	}

	/**
	 * @param vscObject $mappedObject
	 * @return bool
	 */
	public function maps(vscObject $mappedObject)
	{
		return (get_class($mappedObject) == $this->getPath());
	}
}
