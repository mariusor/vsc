<?php
/**
 * @package application
 * @subpackage processors
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.08.31
 */
namespace vsc\application\processors;

use vsc\application\sitemaps\ClassMap;
use vsc\application\sitemaps\MappingA;
use vsc\domain\models\ModelA;
use vsc\infrastructure\vsc;
use vsc\infrastructure\BaseObject;
use vsc\presentation\requests\HttpRequestA;
use vsc\presentation\responses\HttpResponse;
use vsc\presentation\responses\HttpResponseA;
use vsc\application\dispatchers\RwDispatcher;

abstract class ProcessorA extends BaseObject implements ProcessorInterface {
	private $oCurrentMap;
	protected $aLocalVars = array();

	/**
	 * @returns ClassMap
	 */
	public function getMap() {
		if (MappingA::isValid($this->oCurrentMap)) {
			return $this->oCurrentMap;
		} else {
			$oMirror = new \ReflectionClass($this);
			return new ClassMap($oMirror->getName(), '.*');
		}
	}

	/**
	 * @param MappingA $oMap
	 */
	public function setMap(MappingA $oMap) {
		$this->oCurrentMap = $oMap;
		$aTainted = $oMap->getTaintedVars();
		if (is_array($aTainted) && count($aTainted) >= 1) {
			$this->setLocalVars($aTainted);
		}
	}

	/**
	 *
	 * @param array $aVars
	 * @param bool $bPreserveKeys
	 * @return void
	 */
	public function setLocalVars($aVars = array(), $bPreserveKeys = false) {
		if ($bPreserveKeys) {
			$this->aLocalVars = array_merge($this->aLocalVars, $aVars);
		} else {
			// This needs improvement to take into account incoming arrays
			//  containing both string keys - which exist or not in the $aLocalVars array
			//  and numeric indexes
			foreach ($this->aLocalVars as $sKey => $sValue) {
				$this->aLocalVars[$sKey] = array_shift($aVars);
			}
		}
	}

	/**
	 * @return array
	 */
	public function getLocalVars() {
		return $this->aLocalVars;
	}

	/**
	 * @param string $sVar
	 * @param string $sValue
	 * @return bool
	 */
	public function setVar($sVar, $sValue) {
		if (array_key_exists($sVar, $this->aLocalVars)) {
			$this->aLocalVars[$sVar] = $sValue;
			return true;
		}
		return false;
	}

	/**
	 * @param string $sVar
	 * @return null
	 */
	public function getVar($sVar) {
		if (array_key_exists($sVar, $this->aLocalVars)) {
			return $this->aLocalVars[$sVar];
		} else {
			return null;
		}
	}

	/**
	 *
	 * @see ProcessorI::delegateRequest()
	 * @param HttpRequestA $oHttpRequest
	 * @param ProcessorA $oNewProcessor
	 * @param HttpResponseA $oResponse
	 * @returns ModelA
	 */
	public function delegateRequest(HttpRequestA $oHttpRequest, ProcessorA $oNewProcessor, HttpResponseA $oResponse = null) {
		$oDispatcher = vsc::getEnv()->getDispatcher();
		/** @var ClassMap $oMap */
		$oMap = $oDispatcher->getSiteMap()->findProcessorMap($oNewProcessor);

		if (MappingA::isValid($oMap)) {
			$oNewProcessor->setMap($oMap);
			$oNewProcessor->init();

			/* @var RwDispatcher $oDispatcher */
			$oMap->merge($this->getMap());

			if (HttpResponse::isValid($oResponse)) {
				$oMap->setResponse($oResponse);
			}

			$this->setMap($oMap);
		}
		$oNewProcessor->setLocalVars($this->getLocalVars(), true);

		return $oNewProcessor->handleRequest($oHttpRequest);
	}
}
