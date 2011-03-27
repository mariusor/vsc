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
}