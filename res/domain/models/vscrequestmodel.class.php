<?php
/**
 * @package vsc_domain
 * @subpackage models
 * @author marius orcsik <marius@habarnam.ro>
 * @date 11.12.01
 */
namespace vsc\domain\models;

use vsc\infrastructure\vsc;

// \vsc\import ('infrastructure');
class vscRequestModel extends vscEmptyModel {
	public function __get ($sVarName) {
		$sVal = vsc::getEnv()->getHttpRequest()->getVar($sVarName);

		if (is_null($sVal) && vsc::getEnv()->isDevelopment()) {
			$sVal = '<span style="font-size:0.8em">['.$sVarName.' does not exist in the request]</span>';
		}

		return $sVal;
	}
}