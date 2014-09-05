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

use vsc\presentation\requests\RwHttpRequest;

class PopulatedRequest extends RwHttpRequest {
	protected $aTaintedVars		= array(
		'module'	=> 'test',
		'cucu'		=> 'mucu',
		'height'	=> 143
	);

	public function __construct() {}

	protected $returnUri = '/test';
	protected $aAccept =  array (
		'application/html',
		'text/html;charset=UTF8',
		'image/*'
	);
	protected $sHttpMethod	= 'GET';

	protected $aGetVars		= array('cucu' => 'pasare','ana' => 'are', 'mere' => '', 'test' => 123);
	protected $aPostVars	= array('postone' => 'are', 'ana' => '');
	protected $aCookieVars	= array('user' => 'asddsasdad234');

	protected $sReferer	= 'http://localhost/fixturesf/index.html?module=test';
	protected $sUserAgent	= 'WGET 2/3';

	public function setUri ($sUri) {
		$this->sUri = $sUri;
	}

	public function setHttpAccept($sAccepts) {
		$this->aAccept = array ($sAccepts);
	}

	public function setContentType ($sContentType) {
		$this->sContentType = $sContentType;
	}

	public function getTaintedVar ($sVarName) {
		return parent::getTaintedVar($sVarName);
	}
	
	public function setGetVars($Vars) {
		$this->aGetVars = $Vars;
	}
	
	public function setPostVars($Vars) {
		$this->aPostVars = $Vars;
	}
	
	public function setCookieVars($Vars) {
		$this->aCookieVars = $Vars;
	}

	public function setHttpMethod ($HttpMethod) {
		$this->sHttpMethod = $HttpMethod;
	}
}
