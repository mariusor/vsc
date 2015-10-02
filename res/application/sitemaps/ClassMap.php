<?php
/**
 * @package vsc\application\sitemaps
 * @author marius orcisk <marius@habarnam.ro>
 * @date 2014.08.07
 */
namespace vsc\application\sitemaps;

use vsc\infrastructure\Object as vscObject;

class ClassMap extends MappingA implements ContentTypeMappingInterface {
	use ProcessorMapTrait;
	use ControllerMapTrait;

	/**
	 * @param string $sPath
	 * @return bool
	 */
	public static function isValidMap($sPath) {
		return class_exists($sPath);
	}

	/**
	 * @param MappingA $oMap
	 * @return bool
	 */
	static public function isValid($oMap) {
		return (parent::isValid($oMap) && $oMap->getPath() !== '');
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
