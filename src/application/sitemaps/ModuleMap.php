<?php
/**
 * @package application
 * @subpackage sitemaps
 * @author marius orcisk <marius@habarnam.ro>
 * @date 2010.12.05
 */
namespace vsc\application\sitemaps;

use vsc\infrastructure\urls\UrlParserA;

class ModuleMap extends MappingA implements ContentTypeMappingInterface, ResourceMapInterface {
	use ModuleMapTrait;
	use ResourceMapTrait;

	/**
	 * @var string
	 */
	private $sMainTemplatePath;
	/**
	 * @var string
	 */
	private $sMainTemplate;

	/**
	 * verifies if $sPath is on the path
	 * verifies if $sPath is a valid folder and it has a config/map.php file
	 * @param string $sPath
	 * @return bool
	 */
	public static function isValidMap ($sPath) {
		return (basename($sPath) == 'map.php' && is_file($sPath));
	}

	public function __construct($sPath, $sRegex) {
		$sPath = realpath(dirname($sPath));
		if (basename($sPath) == 'config') {
			$sPath = substr($sPath, 0, -7);
		}

		$sPath .= DIRECTORY_SEPARATOR;
		parent::__construct($sPath, $sRegex);
	}

	public function setMainTemplatePath($sPath) {
		$this->sMainTemplatePath = $this->getValidPath($sPath);
	}

	public function getMainTemplatePath() {
		return $this->sMainTemplatePath;
	}

	public function setMainTemplate($sPath) {
		$this->sMainTemplate = $sPath;
	}

	public function getMainTemplate() {
		return $this->sMainTemplate;
	}

	public function getNamespace() {
		return '';
	}

	/**
	 * @return string
	 */
	public function getModulePath() {
		$sModulePath = $this->getPath();
		if (!ModuleMap::isValidMap($sModulePath) && ClassMap::isValidMap($sModulePath)) {
			$sModulePath = $this->getModuleMap()->getModulePath();
		}

		if (!UrlParserA::hasGoodTermination($sModulePath, DIRECTORY_SEPARATOR)) {
			$sModulePath .= DIRECTORY_SEPARATOR;
		}
		return $sModulePath;
	}
}
