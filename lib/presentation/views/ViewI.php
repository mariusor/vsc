<?php
/**
 * @package presentation
 * @subpackage views
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.11.19
 */
namespace vsc\presentation\views;

interface ViewI {

	/**
	 * appends values to template variables
	 *
	 * @param array|string $tplVar the template variable name(s)
	 * @param mixed $value the value to append
	 * @param bool $merge
	 * @return bool
	 */
	function append($tplVar, $value = null, $merge = false);

	/**
	 * assigns values to template variables
	 *
	 * @param array|string $tplVar the template variable name(s)
	 * @param mixed $value the value to assign
	 * @return bool
	 */
	function assign($tplVar, $value = null);

	/**
	 * executes & displays the template results
	 *
	 * @param string $resourceName
	 * @return bool
	 */
	function display($resourceName);

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
