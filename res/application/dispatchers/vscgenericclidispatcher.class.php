<?php
/**
 * Parses the current request into a valid Front Controller / Controller pair
 * @package vsc_application
 * @subpackage dispatchers
 * @author marius orcsik <marius@habarnam.ro>
 * @date 14.07.26
 */
namespace vsc\application\dispatchers;

class vscGenericCLIDispatcher extends vscCLIDispatcherA {
	/**
	 * @return vscFrontControllerA
	 */
	public function getFrontController () {
		// TODO: Implement getFrontController() method.
	}

	/**
	 * @return vscProcessorA
	 */
	public function getProcessController () {
		// TODO: Implement getProcessController() method.
	}

	public function getView () {
		// TODO: Implement getView() method.
	}

	/**
	 * @param string $sIncPath
	 * @throws vscExceptionPath
	 * @return void
	 */
	public function loadSiteMap ( $sIncPath ) {
		// TODO: Implement loadSiteMap() method.
	}
} 
