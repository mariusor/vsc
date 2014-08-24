<?php
namespace fixtures\presentation\requests;

$_GET		= array ('cucu' => 'pasare','ana' => 'are', 'mere' => '', 'test' => 123);
$_POST		= array ('postone' => 'are', 'ana' => '');
$_COOKIE	= array ('user' => 'asddsasdad234');
$_SERVER	= array (
	'SERVER_SOFTWARE' => 'lighttpd',
	'PHP_SELF' => '/',
	'REQUEST_URI' => '/test/ana:are/test:123/',
	'HTTP_ACCEPT' => 'application/html,text/html;charset=UTF8,image/*'
);


use vsc\presentation\requests\HttpAuthenticationA;
use vsc\rest\presentation\requests\RESTRequest;

class PopulatedRESTRequest extends RESTRequest {
	protected $aAccept =  array (
		'application/html',
		'text/html;charset=UTF8',
		'image/*'
	);

	protected $aGetVars		= array('cucu' => 'pasare','ana' => 'are', 'mere' => '', 'test' => 123);
	protected $aPostVars	= array('postone' => 'are', 'ana' => '');
	protected $aCookieVars	= array('user' => 'asddsasdad234');

	public function setAuthentication (HttpAuthenticationA $oHttpAuthentication) {
		parent::setAuthentication($oHttpAuthentication);
	}

	public function setHttpAccept($sAccepts) {
		$this->aAccept = array ($sAccepts);
	}

	/**
	 * @return string[]
	 */
	public function getHttpAccept () {
		return $this->aAccept;
	}

	public function setContentType ($sContentType) {
		$this->sContentType = $sContentType;
	}

	public function constructRawVars ($sRawInput = null) {
		parent::constructRawVars($sRawInput);
	}
}
