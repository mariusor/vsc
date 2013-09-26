<?php
/**
 * @package vsc_application
 * @subpackage processors
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.08.31
 */
import ('presentation/views');
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
	 */
	public function setVar ($sVar, $sValue) {
		if (key_exists ($sVar, $this->aLocalVars)) {
			$this->aLocalVars[$sVar] = $sValue;
			return true;
		}
		return false;
	}

	/**
	 * @param string $sVar
	 */
	public function getVar ($sVar) {
		if (key_exists ($sVar, $this->aLocalVars)) {
			return $this->aLocalVars[$sVar];
		} else {
			return null;
		}
	}

	/**
	 * (non-PHPdoc)
	 * @see vscProcessorI::delegateRequest()
	 */
	public function delegateRequest(vscHttpRequestA $oHttpRequest, vscProcessorA $oNewProcessor, vscHttpResponseA $oResponse = null) {
		$oDispatcher = vsc::getEnv()->getDispatcher();
		$oMap = $oDispatcher->getSiteMap()->findProcessorMap($oNewProcessor);

		$oNewProcessor->init();
		if (vscMappingA::isValid($oMap)) {
			$oNewProcessor->setMap($oMap);
			/* @var $oDispatcher vscRwDispatcher */
			$oMap->merge ($this->getMap());

			if (vscHttpResponse::isValid($oResponse)) {
				$oMap->setResponse($oResponse);
			}
			$this->setMap ($oMap);
		}

		$oNewProcessor->setLocalVars($this->getLocalVars(), true);

		return $oNewProcessor->handleRequest($oHttpRequest);
	}
}
