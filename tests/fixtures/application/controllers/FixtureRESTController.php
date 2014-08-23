<?php
/**
 * Created by PhpStorm.
 * User: habarnam
 * Date: 8/22/14
 * Time: 12:53 PM
 */

namespace fixtures\application\controllers;

use avangate\application\controllers\RESTController;
use vsc\presentation\responses\HttpResponseA;

class FixtureRESTController extends RESTController {
	static public function getCacheKey(HttpResponseA $oResponse) {
		return parent::getCacheKey($oResponse);
	}
} 