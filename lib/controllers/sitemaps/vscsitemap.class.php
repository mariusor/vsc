<?php
/**
 * @package vsc_controller
 * @subpackage vsc_sitemap
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.08.30
 */
class vscSiteMap {
	private $aMappings;

	public function addMap ($sUrl, $sIncPath) {
		try {
			include ($sIncPath);
		} catch (vscException $e) {
			//
		}
	}

	public function addEntry ($sUrl, $sControllerPath) {
		if (!$sUrl) {
			throw new vscExceptionSitemap ('A path must be present.');
		}
		if (!$sControllerPath || !is_file ($sControllerPath)) {
			throw new vscExceptionSitemap ('The controller [' . basename ($sControllerPath). '] could not be resolved.');
		}
		include ($sControllerPath);
	}
}
