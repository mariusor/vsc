<?php
namespace mocks\application\sitemaps;

use vsc\application\sitemaps\MappingA;

class MapFixture extends MappingA
{
	public function __construct ($sPath = null, $sRegex = null) {
		if (is_null($sPath)) {
			$sPath = __FILE__;
		}
		if (is_null($sRegex)) {
			$sRegex = '.*';
		}
		parent::__construct($sPath, $sRegex);
	}
	/**
	 * @return string
	 */
	public function getTitle() {}
	/**
	 * @param string $sTitle
	 */
	public function setTitle($sTitle) {}

	/**
	 * @param MappingA $oMap
	 */
	protected function mergeResources($oMap) {}


}
