<?php
/**
 * @package presentation
 * @subpackage views
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.11.19
 */
namespace vsc\presentation\views;

interface ViewInterface {
	/**
	 * executes & returns or displays the template results
	 *
	 * @param string $resourceName
	 */
	function fetch($resourceName);

	/**
	 * @return string
	 */
	function getTemplate();
}
