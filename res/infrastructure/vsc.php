<?php
/**
 * @package infrastructure
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.08.31
 */
namespace vsc\infrastructure;

use vsc\application\dispatchers\DispatcherA;
use vsc\application\dispatchers\HttpDispatcherA;
use vsc\application\dispatchers\RwDispatcher;
use vsc\application\sitemaps\ModuleMap;
use vsc\Exception;
use vsc\presentation\requests\HttpRequestA;
use vsc\presentation\requests\RawHttpRequest;
use vsc\presentation\requests\RwHttpRequest;
use vsc\presentation\responses\HttpResponse;
use vsc\presentation\responses\HttpResponseA;

class vsc extends Object {
	/**
	 * @var vsc
	 */
	static private $oInstance;

	/**
	 * @var HttpRequestA
	 */
	private $oRequest = null;

	/**
	 * @var HttpResponseA
	 */
	private $oResponse = null;

	/**
	 * @var DispatcherA
	 */
	private $oDispatcher;

	/**
	 * @param vsc $envObject
	 */
	static public function setInstance (vsc $envObject) {
		self::$oInstance = $envObject;
	}

	/**
	 * @return vsc
	 */
	static public function getEnv () {
		if (!(vsc::isValid(self::$oInstance))) {
			self::$oInstance = new self();
		}
		return self::$oInstance;
	}

	/**
	 * @param HttpRequestA $oRequest
	 */
	public function setHttpRequest (HttpRequestA $oRequest) {
		if ( HttpRequestA::isValid($oRequest) ) {
			$this->oRequest = $oRequest;
		}
	}

	/**
	 * @returns HttpRequestA
	 */
	public function getHttpRequest () {
		if ( is_null($this->oRequest) ){
			if (!HttpRequestA::hasContentType()) {
				$this->oRequest = new RwHttpRequest();
			} else {
				$this->oRequest = new RawHttpRequest();
			}
		}
		return $this->oRequest;
	}

	/**
	 * @param HttpResponseA $oResponse
	 */
	public function setHttpResponse (HttpResponseA $oResponse) {
		if (HttpResponseA::isValid($oResponse)  && get_class($this->oResponse) != get_class($oResponse)) {
			$this->oResponse = $oResponse;
		}
	}

	/**
	 * @returns HttpResponseA
	 */
	public function getHttpResponse () {
		if ( is_null($this->oResponse) ){
			$this->oResponse = new HttpResponse();
		}
		return $this->oResponse;
	}

	/**
	 * @param HttpDispatcherA $oDispatcher
	 */
	public function setDispatcher ($oDispatcher) {
		if (DispatcherA::isValid($oDispatcher)){
			$this->oDispatcher = $oDispatcher;
		}
	}

	/**
	 * @returns HttpDispatcherA
	 */
	public function getDispatcher () {
		if (!DispatcherA::isValid($this->oDispatcher)){
			$this->oDispatcher = new RwDispatcher();
		}
		return $this->oDispatcher;
	}

	/**
	 * @return boolean
	 */
	public function isDevelopment () {
		return (
			self::isCli() || (
				stristr($_SERVER['REMOTE_ADDR'], '127.0.0.1') != false ||
				stristr($_SERVER['REMOTE_ADDR'], '192.168') != false
			)
		);
	}

	/**
	 * @return bool
	 */
	protected function _isCli () {
		return (php_sapi_name() == 'cli');
	}

	/**
	 * @return bool
	 */
	static public function isCli() {
		return self::getEnv()->_isCli();
	}

	/**
	 * @return string
	 */
	static public function name() {
		return 'V<sup>S<sup>C</sup></sup>';
	}

	/**
	 * returns an end of line, based on the environment
	 * @return string
	 */
	static public function nl () {
		return self::isCli() ? "\n" : '<br/>' . "\n";
	}

	static public function d () {
		$aRgs = func_get_args();

		$output = '';
		for ($i = 0; $i < ob_get_level(); $i++) {
			// cleaning the buffers
			ob_end_clean();
		}

		if (!self::isCLi() && self::getEnv()->getHttpRequest()->accepts('application/json')) {
			$output = json_encode($aRgs);
		} elseif (self::isCLi() || self::getEnv()->getHttpRequest()->accepts('text/html')) {
			foreach ($aRgs as $object) {
				ob_start ();
				var_dump ( $object );
				$output .= ob_get_clean ();

				if (!self::isCli()) {
					$output .= '<hr/>' . "\n";
				}
			}
		}

		if (!stristr($_SERVER['PHP_SELF'], 'phpunit')) {
			ob_start();
			debug_print_backtrace();
			$output .= ob_get_clean();

			if (self::isCLi() || self::getEnv()->getHttpRequest()->accepts('application/json')) {
				echo String::stripTags(String::br2nl($output));
			} elseif (self::getEnv()->getHttpRequest()->accepts('text/html')) {
				echo '<pre>' . $output . '</pre>';
			} else {
				echo String::stripTags(String::br2nl($output));
			}

			exit ();
		} else {
			return $output;
		}
	}

	static function getIncludePaths() {
		return explode (PATH_SEPARATOR, get_include_path());
	}

	/**
	 * @returns ModuleMap
	 */
	public function getCurrentModuleMap () {
		return $this->getDispatcher()->getCurrentModuleMap();
	}

	static public function getPaths () {
		return explode (PATH_SEPARATOR, get_include_path());
	}
}
