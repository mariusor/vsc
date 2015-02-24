<?php
/**
 * @package application
 * @subpackage sitemaps
 * @author marius orcisk <marius@habarnam.ro>
 * @date 2010.12.05
 */
namespace vsc\application\sitemaps;

class ModuleMap extends MappingA implements ContentTypeMappingI {
	private $sMainTemplatePath;
	private $sMainTemplate;

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

		$sModulePath = realpath(dirname($sModulePath));
		if (basename($sModulePath) == 'config') {
			$sModulePath = substr($sModulePath, 0, -7);
		}
		return $sModulePath.DIRECTORY_SEPARATOR;
	}
}
