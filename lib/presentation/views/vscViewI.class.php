<?php
/**
 * @package vsc_presentation
 * @subpackage views
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.11.19
 */
namespace vsc\presentation\views;

interface vscViewI {

	/**
	 * appends values to template variables
	 *
	 * @param array|string $tpl_var the template variable name(s)
	 * @param mixed $value the value to append
	 */
	function append($tpl_var, $value=null, $merge=false);

	/**
	 * assigns values to template variables
	 *
	 * @param array|string $tpl_var the template variable name(s)
	 * @param mixed $value the value to assign
	 */
	function assign($tpl_var, $value = null);

	/**
	 * executes & displays the template results
	 *
	 * @param string $resource_name
	 */
	function display($resource_name);

	/**
	 * executes & returns or displays the template results
	 *
	 * @param string $resource_name
	 */
	function fetch($resource_name);

	/**
	 * @return string
	 */
	function getTemplate ();
}