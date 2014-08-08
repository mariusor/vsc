<?php
/**
 * @package infrastructure
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.08.31
 */
namespace vsc\infrastructure;

use vsc\application\dispatchers\DispatcherA;
use vsc\application\dispatchers\GenericCLIDispatcher;
use vsc\application\dispatchers\HttpDispatcherA;
use vsc\application\dispatchers\RwDispatcher;
use vsc\application\sitemaps\ModuleMap;
use vsc\presentation\requests\CLIRequest;
use vsc\presentation\requests\HttpRequestA;
use vsc\presentation\requests\RawHttpRequest;
use vsc\presentation\requests\RwHttpRequest;

class vsc extends Object {
	/**
	 * @var
	 */
	static private $oInstance;

	/**
	 * @var HttpRequestA
	 */
	private $oRequest = null;

	/**
	 * @var DispatcherA
	 */
	private $oDispatcher;

	static public function setInstance ($vscObject) {
		if ($vscObject instanceof self) {
			self::$oInstance = $vscObject;
		}
	}

	static public function getEnv () {
		if (!(self::isValid(self::$oInstance))) {
			self::$oInstance = new static();
		}
		return self::$oInstance;
	}

	/**
	 * @param HttpRequestA $oRequest
	 */
	public function setHttpRequest (HttpRequestA $oRequest) {
		if (HttpRequestA::isValid($oRequest)  && get_class($this->oRequest) != get_class($oRequest)) {
			$this->oRequest = $oRequest;
		}
	}

	/**
	 * @returns HttpRequestA
	 */
	public function getHttpRequest () {
		if ( is_null($this->oRequest) ){
			if ( !self::isCli() ) {
				if (!HttpRequestA::hasContentType()) {
					$this->oRequest = new RwHttpRequest();
				} else {
					$this->oRequest = new RawHttpRequest();
				}
			} else {
				$this->oRequest = new CLIRequest();
			}
		}
		return $this->oRequest;
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
			if ( !self::isCli() ) {
				$this->oDispatcher = new RwDispatcher();
			} else {
				$this->oDispatcher = new GenericCLIDispatcher();
			}
		}
		return $this->oDispatcher;
	}

	/**
	 *
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
	static public function isCli () {
		return (php_sapi_name() == 'cli');
	}

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
		$iExit = 1;

		$output = '';
		for ($i = 0; $i < ob_get_level(); $i++) {
			// cleaning the buffers
			ob_end_clean();
		}

		foreach ($aRgs as $object) {
			// maybe I should just output the whole array $aRgs
			try {
				ob_start();
				var_dump ($object);
				$output = ob_get_clean();
			} catch (\Exception $e) {
				//
			}
		}
		ob_start();
		debug_print_backtrace();

		$output .= ob_get_clean();

		if (self::isCLi() || self::getHttpRequest()->accepts('application/json')) {
			echo String::stripTags(String::br2nl($output));
		} elseif (self::getHttpRequest()->accepts('text/html')) {
			echo '<pre>' . $output . '</pre>';
		} else {
			echo String::stripTags(String::br2nl($output));
		}

		exit ();
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
