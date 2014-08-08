<?php
/**
 * @package presentation/requests
 * @author marius orcsik <marius@habarnam.ro>
 * @date 2013.10.04
 */
namespace vsc\presentation\requests;

class RESTRequest extends RawHttpRequest {

	static private $validContentTypes = array(
		'application/json'
	);

	static public function validContentType ($sContentType) {
		return in_array($sContentType, self::$validContentTypes);
	}
}
