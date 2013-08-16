<?php
class vscNullView extends vscNull implements vscViewI {
	function append($tpl_var, $value=null, $merge=false) {}
	function assign($tpl_var, $value = null) {}
	function display($resource_name) {}
	function fetch($resource_name) {}
	function getTemplate () {}
}