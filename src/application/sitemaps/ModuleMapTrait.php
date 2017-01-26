<?php
/**
 * @package application
 * @subpackage sitemaps
 * @author marius orcisk <marius@habarnam.ro>
 * @date 17.01.25
 */
namespace vsc\application\sitemaps;


trait ModuleMapTrait
{
	/**
	 * @var MappingA
	 */
	private $oParentMap;

	public function setModuleMap(MappingA $oMap) {
		$this->oParentMap = $oMap;
	}

	/**
	 * @returns ModuleMap
	 */
	public function getModuleMap() {
		if (!MappingA::isValid($this->oParentMap)) {
			$this->oParentMap = new RootMap(VSC_SRC_PATH . 'config/map.php');
		}
		return $this->oParentMap;
	}

	/**
	 * @return string
	 * @throws ExceptionSitemap
	 */
	public function getModulePath() {
		$oModuleMap = $this->getModuleMap();
		return $oModuleMap->getModulePath();
	}

	/**
	 * @return string
	 */
	public function getModuleName() {
		return $this->getModulePath() ? basename($this->getModulePath()) : null;
	}
}
