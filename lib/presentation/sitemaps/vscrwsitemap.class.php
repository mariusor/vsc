<?php
/**
 * @package vsc_presentation
 * @subpackage sitemaps
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.08.30
 */
class vscRwSiteMap extends vscSiteMapA {
//
//	protected function addModuleIncludePath ($sPath) {
//		$path 		= get_include_path();
//		if (is_dir ($sPath)) {
//			if (strpos ($path, $sPath . PATH_SEPARATOR) === false) {
//				// adding exceptions dir to include path if it exists
//				if (is_dir ($sPath . 'exceptions')) {
//					// adding the exceptions if they exist
//					$sPath .= PATH_SEPARATOR . $sPath . 'exceptions' . DIRECTORY_SEPARATOR;
//				}
//				set_include_path (
//					$path . PATH_SEPARATOR . $sPath . PATH_SEPARATOR
//				);
//			}
//			return true;
//		} else{
//			throw new vscExceptionModuleImport ('Bad module "' . $sPath . '"');
//		}
//	}
//
//	protected function isValidModule ($sModulePath) {
//		if (is_file ($this->getBasePath() . $sModulePath)) {
//			return (include ($this->getBasePath() . $sControllerName));
//		} else {
//			;
//		}
//	}
//
//
//
//	public function map ($sRegex, $sControllerName) {
//		if (!$sRegex) {
//			throw new vscExceptionSitemap ('An url must be present.');
//		}
//		if (!$sControllerName || $this->isValidController ($sControllerName)) {
//			throw new vscExceptionSitemap ('The controller [' . ($sControllerName). '] could not be resolved.');
//		}
//
//	}
//
//	public function addModule ($sRegex, $sModulePath) {
//		if (!$sRegex) {
//			throw new vscExceptionSitemap ('An url must be present.');
//		}
//		if (!$sModulePath || !is_dir ($sModulePath)) {
//			throw new vscExceptionSitemap ('The module path [' . ($sModulePath). '] is invalid.');
//		}
//
//		$this->addModuleIncludePath ($sModulePath);
//	}
}
