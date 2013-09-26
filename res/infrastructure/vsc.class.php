<?php
/**
 * @package vsc_infrastructure
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.08.31
 */
import ('presentation/requests');
import ('application/dispatchers');
import (dirname(__FILE__));
class vsc extends vscObject {
	/**
	 * @var vsc
	 */
	static private $oInstance;

	/**
	 * @var vscHttpRequestA
	 */
	private $oRequest = null;

	/**
	 * @var vscDispatcherA
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
	 * @param $oRequest vscHttpRequestA
	 */
	public function setHttpRequest (vscHttpRequestA $oRequest) {
		if (vscHttpRequestA::isValid($oRequest)  && get_class($this->oRequest) != get_class($oRequest)) {
			$this->oRequest = $oRequest;
		}
	}

	/**
	 * @return vscHttpRequestA
	 */
	public function getHttpRequest () {
		if ( is_null($this->oRequest) ){
			if ( !vsc::isCli() ) {
				if (!vscHttpRequestA::hasContentType()) {
					$this->oRequest = new vscRwHttpRequest();
				} else {
					$this->oRequest = new vscRawHttpRequest();
				}
			} else {
				$this->oRequest = new vscCLIRequest();
			}
		}
		return $this->oRequest;
	}

	/**
	 * @param $oDispatcher vscHttpDispatcherA
	 */
	public function setDispatcher ($oDispatcher) {
		if (vscDispatcherA::isValid($oDispatcher)){
			$this->oDispatcher = $oDispatcher;
		}
	}

	/**
	 * @return vscHttpDispatcherA
	 */
	public function getDispatcher () {
		if (!vscDispatcherA::isValid($this->oDispatcher)){
			$this->oDispatcher = new vscRwDispatcher();
		}
		return $this->oDispatcher;
	}

	/**
	 *
	 * @return boolean
	 */
	public function isDevelopment () {
		return (
			isCli() || (
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
		return isCli() ? "\n" : '<br/>' . "\n";
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
			} catch (Exception $e) {
				//
			}
		}
		ob_start();
		debug_print_backtrace();

		$output .= ob_get_clean();

		if (isCLi() || self::getHttpRequest()->accepts('application/json')) {
			echo vscString::stripTags(vscString::br2nl($output));
		} elseif (self::getHttpRequest()->accepts('text/html')) {
			echo '<pre>' . $output . '</pre>';
		} else {
			echo vscString::stripTags(vscString::br2nl($output));
		}

		exit ();
	}

	static function getIncludePaths() {
		return explode (PATH_SEPARATOR, get_include_path());
	}

	/**
	 * @return vscModuleMap
	 */
	public function getCurrentModuleMap () {
		return $this->getDispatcher()->getCurrentModuleMap();
	}

	static public function getPaths () {
		return explode (PATH_SEPARATOR, get_include_path());
	}
}
