<?php
/**
 * @package vsc_application
 * @subpackage sitemaps
 * @author marius orcisk <marius@habarnam.ro>
 * @date 2010.12.05
 */

class vscProcessorMap extends vscMappingA {
	/**
	 *
	 * @var vscHttpResponseA
	 */
	private $oResponse;

	/**
	 *
	 * @var vscViewHelpersA[]
	 */
	private $oHelpers;

	/**
	 * @param vscHttpResponseA $oResponse
	 */
	public function setResponse (vscHttpResponseA $oResponse) {
		$this->oResponse = $oResponse;
	}

	/**
	 * @return vscHttpResponseA
	 */
	public function getResponse () {
		return $this->oResponse;
	}

	/**
	 *
	 * @param string $sRegex
	 * @param string $sPath
	 * @throws vscExceptionSitemap
	 * @return vscControllerMap
	 */
	public function mapController ($sRegex, $sPath = null){
		if (is_null($sPath)) {
			// if we only have one parameter, we treat it as a path
			$sPath = $sRegex;
			$sRegex = $this->getRegex();
		}
		return parent::mapController($sRegex, $sPath);
	}

	/**
	 * @param vscViewHelperA $oHelper
	 * @return void
	 */
	public function registerHelper (vscViewHelperA $oHelper) {
		$this->oHelpers[] = $oHelper;
	}

	/**
	 * @return vscViewHelpersA[]
	 */
	public function getViewHelpers () {
		return $this->oHelpers;
	}
}