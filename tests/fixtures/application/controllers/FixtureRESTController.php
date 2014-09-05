<?php
namespace fixtures\application\controllers;

use vsc\infrastructure\Null;
use vsc\rest\application\controllers\RESTController;
use vsc\presentation\responses\HttpResponseA;

class FixtureRESTController extends RESTController {
	static public function getCacheKey(HttpResponseA $oResponse) {
		return substr(sha1(':' . serialize(new Null())), 0, 8);
	}
} 
