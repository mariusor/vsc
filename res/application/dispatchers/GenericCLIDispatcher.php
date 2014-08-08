<?php
/**
 * Parses the current request into a valid Front Controller / Controller pair
 * @package application
 * @subpackage dispatchers
 * @author marius orcsik <marius@habarnam.ro>
 * @date 14.07.26
 */
namespace vsc\application\dispatchers;

use vsc\application\controllers\FrontControllerA;
use vsc\application\processors\ProcessorA;
use vsc\presentation\views\ViewA;
use vsc\ExceptionPath;

class GenericCLIDispatcher extends CLIDispatcherA {
	/**
	 * @returns FrontControllerA
	 */
	public function getFrontController () {
		// TODO: Implement getFrontController() method.
	}

	/**
	 * @returns ProcessorA
	 */
	public function getProcessController () {
		// TODO: Implement getProcessController() method.
	}

	/**
	 * @returns ViewA
	 */
	public function getView () {
		// TODO: Implement getView() method.
	}

	/**
	 * @param string $sIncPath
	 * @throws ExceptionPath
	 * @return void
	 */
	public function loadSiteMap ( $sIncPath ) {
		// TODO: Implement loadSiteMap() method.
	}
}
