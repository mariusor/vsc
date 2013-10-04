<?php

class vscRESTRequest extends vscRawHttpRequest {

	static private $validContentTypes = array(
		'application/json'
	);

	static public function validContentType ($sContentType) {
		return in_array($sContentType, self::$validContentTypes);
	}
}
