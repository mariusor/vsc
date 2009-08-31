<?php
/**
 * @package vsc_presentation
 * @subpackage sitemaps
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.08.30
 */
class vscSiteMap {
	private $aMappings;

	public function addEntry ($sUrl, $sControllerPath) {
		if (!$sUrl) {
			throw new vscExceptionSitemap ('A path must be present.');
		}
		if (!$sControllerPath || !is_file ($sControllerPath)) {
			throw new vscExceptionSitemap ('The controller [' . ($sControllerPath). '] could not be resolved.');
		}
		include ($sControllerPath);
	}
}
