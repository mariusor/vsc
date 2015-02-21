<?php
/**
 * @package application
 * @subpackage sitemaps
 * @author marius orcisk <marius@habarnam.ro>
 * @date 2010.12.05
 */
namespace vsc\application\sitemaps;

class ProcessorMap extends MappingA {
	use ProcessorMapT;

	/**
	 * @param string $sRegex
	 * @param string $sPath
	 * @throws ExceptionSitemap
	 * @returns ControllerMap
	 */
	public function mapController($sRegex, $sPath = null) {
		if (is_null($sPath)) {
			// if we only have one parameter, we treat it as a path
			$sPath = $sRegex;
			$sRegex = $this->getRegex();
		}
		return parent::mapController($sRegex, $sPath);
	}
}
