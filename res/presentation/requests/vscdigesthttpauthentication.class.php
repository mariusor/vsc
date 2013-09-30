<?php
class vscDigestHttpAuthentication extends vscHttpAuthenticationA {
	public $username;

	protected $Type = vscHttpAuthenticationA::DIGEST;
	protected $HTTPMethod;

	private $nonce;
	private $nc;
	private $cnonce;
	private $qop;
	private $uri;
	private $response;

	public function __construct ($sDigestResponse, $sHTTPMethod = vscHttpRequestTypes::GET) {
		$aNeededParts = array(
			'nonce' => 1,
			'nc' => 1,
			'cnonce' => 1,
			'qop' => 1,
			'username' => 1,
			'uri' => 1,
			'response' => 1
 		);

		$keys = implode ('|', array_keys($aNeededParts));
		$i = preg_match_all('@(' . $keys . ')=(?:([\'"])([^\2]+?)\2|([^\s,]+))@', $sDigestResponse, $aMatches, PREG_SET_ORDER);

		if ($i) {
			foreach ($aMatches as $m) {
				$sProperty = $m[1];
				$this->$sProperty = $m[3] ? $m[3] : $m[4];
				unset($aNeededParts[$m[1]]);
			}
		}
		$this->HTTPMethod = $sHTTPMethod;
	}

	public function validateDigestAuthentication ($sPassword, $sRealm) {
		$A1 = md5($this->username . ':' . $sRealm . ':' . $sPassword);
		$A2 = md5($this->HTTPMethod . ':' . $this->uri);
		$sValidResponse = md5($A1.':'.$this->nonce.':'.$this->nc.':'.$this->cnonce.':'.$this->qop.':'.$A2);

		return $sValidResponse == $this->response;
	}
}
