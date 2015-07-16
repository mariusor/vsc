<?php
namespace fixtures\presentation\views;

use vsc\presentation\views\ViewA;

class testView extends ViewA {
	/**
	 * This is a helper method to allow us to set a non-public parameter
	 * @param string $sFolder
	 */
	public function setFolder ($sFolder) {
		$this->sFolder = $sFolder;
	}

	/**
	 * appends values to template variables
	 *
	 * @param array|string $tplVar the template variable name(s)
	 * @param mixed $value the value to append
	 */
	function append ( $tplVar, $value = null, $merge = false ) {
		// TODO: Implement append() method.
	}

	/**
	 * assigns values to template variables
	 *
	 * @param array|string $tplVar the template variable name(s)
	 * @param mixed $value the value to assign
	 */
	function assign ( $tplVar, $value = null ) {
		// TODO: Implement assign() method.
	}

	/**
	 * executes & displays the template results
	 *
	 * @param string $resourceName
	 */
	function display ( $resourceName ) {
		// TODO: Implement display() method.
	}
}

