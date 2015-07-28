<?php
/**
 * @package presentation
 * @subpackage requests
 * @author marius orcsik <marius@habarnam.ro>
 * @date 2013.09.26
 */
namespace vsc\presentation\requests;

class DigestHttpAuthentication extends HttpAuthenticationA {
	/**
	 * @var string
	 */
	public $username;
	/**
	 * @var int
	 */
	protected $Type = HttpAuthenticationA::DIGEST;
	/**
	 * @var string
	 */
	protected $HTTPMethod;
	/**
	 * @var string
	 */
	private $nonce;
	/**
	 * @var string
	 */
	private $nc;
	/**
	 * @var string
	 */
	private $cnonce;
	/**
	 * @var string
	 */
	private $qop;
	/**
	 * @var string
	 */
	private $uri;
	/**
	 * @var string
	 */
	private $response;
	/**
	 * @param string $sDigestResponse
	 * @param string $sHTTPMethod
	 */
	public function __construct($sDigestResponse, $sHTTPMethod = HttpRequestTypes::GET) {
		$aNeededParts = array(
			'nonce' => 1,
			'nc' => 1,
			'cnonce' => 1,
			'qop' => 1,
			'username' => 1,
			'uri' => 1,
			'response' => 1
 		);

		$keys = implode('|', array_keys($aNeededParts));
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

	/**
	 * @param string $sPassword
	 * @param string $sRealm
	 * @return bool
	 */
	public function validateDigestAuthentication($sPassword, $sRealm) {
		$a1 = md5($this->username . ':' . $sRealm . ':' . $sPassword);
		$a2 = md5($this->HTTPMethod . ':' . $this->uri);
		$sValidResponse = md5($a1 . ':' . $this->nonce . ':' . $this->nc . ':' . $this->cnonce . ':' . $this->qop . ':' . $a2);

		return $sValidResponse == $this->response;
	}
}
