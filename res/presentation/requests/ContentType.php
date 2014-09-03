<?php
namespace vsc\presentation\requests;

use vsc\infrastructure\Null;

class ContentType extends Null {
	static public function isAccepted ($sContentType, $aContentTypes) {
		foreach ($aContentTypes as $key => $sEntry) {
			$iSemicolonPosition = strpos($sEntry, ';');
			if ($iSemicolonPosition > 0) {
				$sTempContentType = substr ($sEntry, 0, $iSemicolonPosition);
				$aContentTypes[$key] = $sTempContentType;
			} else {
				$aContentTypes[$key] = $sEntry;
			}
		}
		list ($sType, $sSubtype) = explode('/', $sContentType);
		foreach ($aContentTypes as $sAcceptedContentType) {
			list ($sAcceptedType, $sAcceptedSubtype) = explode('/', $sAcceptedContentType);

			if ($sAcceptedType == $sType && $sAcceptedSubtype == $sSubtype) return true;
			if ($sAcceptedType == $sType && $sAcceptedSubtype == '*') return true;
			if ($sAcceptedType == '*' && $sAcceptedSubtype == '*') return true;
		}
		return false;
	}
} 