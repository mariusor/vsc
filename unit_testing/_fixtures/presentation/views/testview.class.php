<?php
use vsc\presentation\views\vscViewA;

class testView extends vscViewA {
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
	 * @param array|string $tpl_var the template variable name(s)
	 * @param mixed $value the value to append
	 */
	function append ( $tpl_var, $value = null, $merge = false ) {
		// TODO: Implement append() method.
	}

	/**
	 * assigns values to template variables
	 *
	 * @param array|string $tpl_var the template variable name(s)
	 * @param mixed $value the value to assign
	 */
	function assign ( $tpl_var, $value = null ) {
		// TODO: Implement assign() method.
	}

	/**
	 * executes & displays the template results
	 *
	 * @param string $resource_name
	 */
	function display ( $resource_name ) {
		// TODO: Implement display() method.
	}
}
