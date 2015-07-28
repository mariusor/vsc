<?php
namespace vsc\presentation\requests;

use vsc\infrastructure\Base;

class ContentType extends Base {
	protected static function isAcceptedType ($sType, $aContentTypes) {

	}
	protected static function isAcceptedSubType ($sSubType, $aContentTypes) {}

	/**
	 * @param $sContentType
	 * @param $aContentTypes
	 * @return bool
	 */
	public static function isAccepted($sContentType, $aContentTypes) {
		list ($sType, $sSubtype) = explode('/', $sContentType);
		foreach ($aContentTypes as $sAcceptedContentType) {
			list ($sAcceptedType, $sAcceptedSubtype) = explode('/', $sAcceptedContentType);
			$iSemicolonPosition = strpos($sAcceptedSubtype, ';');
			if ($iSemicolonPosition > 0) {
				// discarding the data after the semicolon in the accepts entry
				$sAcceptedSubtype = substr($sAcceptedSubtype, 0, $iSemicolonPosition);
			}

			if ($sAcceptedType == $sType && $sAcceptedSubtype == $sSubtype) {
				return true;
			}
			if ($sAcceptedType == $sType && $sAcceptedSubtype == '*') {
				return true;
			}
			if ($sAcceptedType == '*' && $sAcceptedSubtype == '*') {
				return true;
			}
		}
		return false;
	}
}
