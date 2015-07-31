<?php
namespace vsc\application\sitemaps;

use vsc\application\controllers\Html5Controller;

class RootMap extends ModuleMap
{
	public function __construct($sPath, $sRegex = '') {
		parent::__construct($sPath, $sRegex);
	}

	public function getControllerMaps() {
		$aControllerMaps = parent::getControllerMaps();
		if (count($aControllerMaps) > 0) {
			return $aControllerMaps;
		} else {
			$sRegex = '\A.*\Z';
			return [$sRegex => new ErrorControllerMap(Html5Controller::class, $sRegex)];
		}
	}
}
