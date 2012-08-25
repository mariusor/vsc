<?php
class vscHttpResponseType {
	public static function getStatus ($iStatus) {
		return isset (static::$aStatusList[$iStatus]) ?  static::$aStatusList[$iStatus] : static::$aStatusList[500];
	}

	public static function isValidStatus ($iStatus) {
		return key_exists($iStatus, static::$aStatusList);
	}

	static protected $aStatusList = array(
		200 => '200 OK',
		204 => '204 No Content',
		301 => '301 Moved Permanently',
		302 => '302 Found',
		303 => '303 See Other',
		304 => '304 Not Modified',
		400 => '400 Bad Request',
		401 => '401 Unauthorized',
		402 => '402 Payment Required',
		403 => '403 Forbidden',
		404 => '404 Not Found',
		405 => '405 Method Not Allowed',
		406 => '406 Not Acceptable',
		408 => '408 Request Timeout',
		409 => '409 Conflict',
		410 => '410 Gone',
		415 => '415 Unsupported Media Type',
		426 => '426 Update Required',
		500 => '500 Internal Server Error',
		501 => '501 Not Implemented',
	);
}
