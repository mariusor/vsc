<?php
/**
 * @package vsc_models
 * @author morcsik
 */
import ('infrastructure');
class vscRequestModel extends vscEmptyModel {
	public function __get ($sVarName) {
		$sVal = vsc::getHttpRequest()->getVar($sVarName);

		if (is_null($sVal) && vsc::getEnv()->isDevelopment()) {
			$sVal = '<span style="font-size:0.8em">['.$sVarName.' does not exist in the request]</span>';
		}

		return $sVal;
	}
}