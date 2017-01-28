<?php
/**
 * @package application
 * @subpackage sitemaps
 * @author marius orcisk <marius@habarnam.ro>
 * @date 09.11.29
 */
namespace vsc\application\sitemaps;

use vsc\application\controllers\ExceptionController;
use vsc\infrastructure\urls\Url;
use vsc\infrastructure\urls\UrlParserA;
use vsc\infrastructure\Base;
use vsc\infrastructure\Object;
use vsc\presentation\requests\HttpAuthenticationA;

abstract class MappingA extends Object {
	/**
	 * @var  string
	 */
	private $sRegex;
	/**
	 * @var string
	 */
	private $sPath;
	/**
	 * @var string
	 */
	private $sTemplate;
	/**
	 * the local template path - will be used to compose something like
	 * this->sViewPath . view->typeOfView . this->sTemplate
	 *
	 * @var string
	 */
	private $sViewPath;

	private $bIsStatic = false;

	private $aControllerMaps = array();

	private $aTaintedVars = [];

	private $sMatchingUrl;

	/**
	 * @var int
	 */
	private $iAuthenticationType = null;

	/**
	 * @param MappingA $oMap
	 */
	abstract protected function mergeResources($oMap);
	/**
	 * @return string
	 */
	abstract public function getTitle();
	/**
	 * @param string $sTitle
	 */
	abstract public function setTitle($sTitle);
	/**
	 * @param string $sPath
	 * @param string $sRegex
	 */
	public function __construct($sPath, $sRegex) {
		$this->sPath = $sPath;
		$this->sRegex = $sRegex;
	}

	public function getRegex() {
		return $this->sRegex;
	}

	/**
	 * @param bool $bStatic
	 */
	public function setIsStatic($bStatic) {
		$this->bIsStatic = $bStatic;
	}

	/**
	 * @return bool
	 */
	public function isStatic() {
		return $this->bIsStatic;
	}

	/**
	 * @param MappingA $oMap
	 */
	protected function mergePaths($oMap) {
		$sParentPath = $oMap->getTemplatePath();
		if (!is_null($sParentPath) && is_null($this->getTemplatePath())) {
			$this->setTemplatePath($sParentPath);
		}

		$sParentTemplate = $oMap->getTemplate();
		if (!is_null($sParentTemplate) && is_null($this->getTemplate())) {
			$this->setTemplate($sParentTemplate);
		}

		if (($this instanceof ContentTypeMappingInterface) && ($oMap instanceof ContentTypeMappingInterface)) {
			/** @var ContentTypeMappingInterface $oMap */
			$sParentMainTemplatePath = $oMap->getMainTemplatePath();
			if (is_null($this->getMainTemplatePath())) {
				$this->setMainTemplatePath($sParentMainTemplatePath);
			}
			$sParentMainTemplate = $oMap->getMainTemplate();
			if (is_null($this->getMainTemplate())) {
				$this->setMainTemplate($sParentMainTemplate);
			}
		}
	}

	/**
	 * @param MappingA $oMap
	 * @return $this
	 */
	public function merge($oMap = null) {
		if (MappingA::isValid($oMap)) {
			$this->mergeResources($oMap);
			$this->mergePaths($oMap);

			$sTitle = $this->getTitle();
			$sMapTitle = $oMap->getTitle();
			if (empty($sTitle) && !empty($sMapTitle)) {
				$this->setTitle($sMapTitle);
			}
			$this->iAuthenticationType |= $oMap->getAuthenticationType();
		}
		return $this;
	}

	/**
	 * @param string $sPath
	 * @return bool
	 * @throws ExceptionSitemap
	 */
	public function setTemplatePath(string $sPath) {
		$this->sViewPath = $this->getValidPath($sPath);
	}

	/**
	 * @return string
	 */
	public function getTemplatePath() {
		return $this->sViewPath;
	}

	/**
	 * @param string $sPath
	 */
	public function setTemplate($sPath) {
		$this->sTemplate = $sPath;
	}

	/**
	 * @return string
	 */
	public function getTemplate() {
		return $this->sTemplate;
	}

	/**
	 * @return string
	 */
	public function getPath() {
		return $this->sPath;
	}

	/**
	 * @deprecated
	 * @param string $sRegex
	 * @param string $sPath
	 * @throws ExceptionController
	 * @throws ExceptionSitemap
	 * @returns ClassMap
	 */
	public function mapController(string $sRegex, string $sPath = null) {
		return $this->map($sRegex, $sPath);
	}

	/**
	 *
	 * @param string $sRegex
	 * @param string $sPath
	 * @throws ExceptionController
	 * @throws ExceptionSitemap
	 * @returns ClassMap
	 */
	public function map(string $sRegex, string $sPath = null) {
		if (empty($sRegex)) {
			throw new ExceptionSitemap('An URI must be present.');
		}
		if (is_null($sPath)) {
			// if we only have one parameter, we treat it as a path
			$sPath = $sRegex;
			$sRegex = $this->getRegex();
		}

		$sKey = $sRegex;
		if (array_key_exists($sKey, $this->aControllerMaps)) {
			unset($this->aControllerMaps[$sKey]);
		}
		if (ClassMap::isValidMap($sPath)) {
			// instead of a path we have a namespace
			$oNewMap = new ClassMap($sPath, $sKey);
			$oNewMap->setModuleMap($this);
			$oNewMap->merge($this);

			$this->aControllerMaps[$sKey] = $oNewMap;

			return $oNewMap;
		}
	}

	/**
	 * @return MappingA[]
	 */
	public function getControllerMaps() {
		return $this->aControllerMaps;
	}

	/**
	 * @param string[] $aVars
	 */
	public function setTaintedVars($aVars) {
		$this->aTaintedVars = $aVars;
	}

	public function getTaintedVars() {
		return $this->aTaintedVars;
	}

	/**
	 * @param string $sUrl
	 */
	public function setUrl($sUrl) {
		$this->sMatchingUrl = $sUrl;
	}

	/**
	 * @returns Url
	 */
	public function getUrl() {
		$sRegex = '#(' . str_replace('#', '\#', $this->getRegex()) . ')#iUu';
		$bHaveMatch = preg_match($sRegex, $this->sMatchingUrl, $aMatches);

		if ($bHaveMatch) {
			$url = new Url();
			$url->setPath($aMatches[0]);
			return $url;
		} else {
			return new Base();
		}
	}

	public function setAuthenticationType($iAuthenticationType) {
		$this->iAuthenticationType = $iAuthenticationType;
	}

	public function getAuthenticationType() {
		return $this->iAuthenticationType;
	}

	/**
	 * @return string
	 */
	public function getValidAuthenticationSchemas() {
		return HttpAuthenticationA::getAuthenticationSchemas($this->iAuthenticationType);
	}

	/**
	 * @return bool
	 */
	public function requiresAuthentication() {
		return ($this->iAuthenticationType != HttpAuthenticationA::NONE);
	}

	/**
	 * @param Object $mappedObject
	 * @return boolean
	 */
	public function maps(Object $mappedObject)
	{
		return (bool)stristr(get_class($mappedObject), substr(basename($this->getPath()), 0, -4));
	}

	/**
	 * @param string $sPath
	 * @return string
	 * @throws ExceptionSitemap
	 */
	protected function getValidPath($sPath) {
		if (!is_dir($sPath)) {
			if (!ModuleMap::isValid($this) && !ModuleMap::isValid($this->getModuleMap())) {
				throw new ExceptionSitemap('No reference module path to use for relative paths');
			}
			$sPath = $this->getModulePath() . $sPath;
		}
		$sPath = realpath($sPath);
		if (!is_dir($sPath)) {
			throw new ExceptionSitemap('Template path is not valid.');
		}

		return $sPath . DIRECTORY_SEPARATOR;
	}
}

