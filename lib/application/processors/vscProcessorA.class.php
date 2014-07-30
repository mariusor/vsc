<?php
/**
 * @package vsc_application
 * @subpackage processors
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.08.31
 */
namespace vsc\application\processors;

// \vsc\import ('presentation/views');
use vsc\application\sitemaps\vscMappingA;
use vsc\application\sitemaps\vscProcessorMap;
use vsc\domain\models\vscModelA;
use vsc\infrastructure\vsc;
use vsc\infrastructure\vscObject;
use vsc\presentation\requests\vscHttpRequestA;
use vsc\presentation\responses\vscHttpResponse;
use vsc\presentation\responses\vscHttpResponseA;
use vsc\application\dispatchers\vscRwDispatcher;

abstract class vscProcessorA extends vscObject implements vscProcessorI {
	private $oCurrentMap;
	protected $aLocalVars = array();

	/**
	 * @return vscProcessorMap
	 */
	public function getMap () {
		if (vscMappingA::isValid ($this->oCurrentMap)) {
			return $this->oCurrentMap;
		} else {
			return new vscProcessorMap ('', '.*');
		}
	}

	/**
	 * @param vscMappingA $oMap
	 */
	public function setMap (vscMappingA $oMap) {
		$this->oCurrentMap = $oMap;
		$aTainted = $oMap->getTaintedVars();
		if (is_array($aTainted) && count ($aTainted) >= 1) {
			$this->setLocalVars($aTainted);
		}
	}

	/**
	 *
	 * @param array $aVars
	 * @param bool $bPreserveKeys
	 * @return void
	 */
	public function setLocalVars ($aVars = array(), $bPreserveKeys = false) {
		if ($bPreserveKeys) {
			$this->aLocalVars = array_merge ($this->aLocalVars, $aVars);
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
	public function getLocalVars () {
		return $this->aLocalVars;
	}

	/**
	 * @param string $sVar
	 * @param string $sValue
	 * @return bool
	 */
	public function setVar ($sVar, $sValue) {
		if (array_key_exists ($sVar, $this->aLocalVars)) {
			$this->aLocalVars[$sVar] = $sValue;
			return true;
		}
		return false;
	}

	/**
	 * @param string $sVar
	 * @return null
	 */
	public function getVar ($sVar) {
		if (array_key_exists ($sVar, $this->aLocalVars)) {
			return $this->aLocalVars[$sVar];
		} else {
			return null;
		}
	}

	/**
	 * 
	 * @see vscProcessorI::delegateRequest()
	 * @param vscHttpRequestA $oHttpRequest
	 * @param vscProcessorA $oNewProcessor
	 * @param vscHttpResponseA $oResponse
	 * @return vscModelA
	 */
	public function delegateRequest(vscHttpRequestA $oHttpRequest, vscProcessorA $oNewProcessor, vscHttpResponseA $oResponse = null) {
		$oDispatcher = vsc::getEnv()->getDispatcher();
		$oMap = $oDispatcher->getSiteMap()->findProcessorMap($oNewProcessor);

		$oNewProcessor->setMap($oMap);
		$oNewProcessor->init();

		/* @var $oDispatcher vscRwDispatcher */
		$oMap->merge ($this->getMap());

		if (vscHttpResponse::isValid($oResponse)) {
			$oMap->setResponse($oResponse);
		}

		$this->setMap ($oMap);

		$oNewProcessor->setLocalVars($this->getLocalVars());

		return $oNewProcessor->handleRequest($oHttpRequest);
	}
}
