<?php
/**
 * @package application
 * @subpackage sitemaps
 * @author marius orcisk <marius@habarnam.ro>
 * @date 2010.12.05
 */
namespace vsc\application\sitemaps;

use vsc\infrastructure\urls\UrlRWParser;

class ModuleMap extends MappingA implements ContentTypeMappingI {
	private $sMainTemplatePath;
	private $sMainTemplate;

	public function __construct($sPath, $sRegex) {
		$sPath = realpath(dirname($sPath));
		if (basename($sPath) == 'config') {
			$sPath = substr($sPath, 0, -7);
		}

		$sPath .= DIRECTORY_SEPARATOR;
		$this->setTemplatePath(VSC_RES_PATH.'templates'.DIRECTORY_SEPARATOR);
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
		if (!SiteMapA::isValidMapPath($sModulePath) && SiteMapA::isValidObjectPath($sModulePath)) {
			$sModulePath = $this->getModuleMap()->getModulePath();
		}

		if (!UrlRWParser::hasGoodTermination($sModulePath, DIRECTORY_SEPARATOR)) {
			$sModulePath .= DIRECTORY_SEPARATOR;
		}
		return $sModulePath;
	}
}
