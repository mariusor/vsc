<?php
/**
 * @package presentation
 * @subpackage responses
 * @author marius orcsik <marius@habarnam.ro>
 * @date 2011.11.20
 */
namespace vsc\presentation\responses;

class HttpResponseType {
	public static function getStatus ($iStatus) {
		return (is_int($iStatus) && array_key_exists($iStatus, static::$aStatusList)) ? static::$aStatusList[$iStatus] : static::$aStatusList[500];
	}

	public static function isValidStatus ($iStatus) {
		return array_key_exists($iStatus, static::$aStatusList);
	}

	static protected $aStatusList = array(
		200 => '200 OK',
		201 => '201 Created',
		202 => '202 Accepted',
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

	static public function getList() {
		return self::$aStatusList;
	}

	const OK = 200;
	const CREATED = 201;
	const ACCEPTED = 202;
	const NO_CONTENT = 204;
	const FOUND = 302;
	const SEE_OTHER = 303;
	const CLIENT_ERROR = 400;
	const NOT_AUTHORIZED = 401;
	const FORBIDDEN = 403;
	const NOT_FOUND = 404;
	const METHOD_NOT_ALLOWED = 405;
	const INTERNAL_ERROR = 500;
}
