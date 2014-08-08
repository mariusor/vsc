<?php
namespace _fixtures\presentation\views;
use vsc\presentation\views\ViewA;

class NullView extends ViewA {
	function append($tpl_var, $value=null, $merge=false) {}
	function assign($tpl_var, $value = null) {}
	function display($resource_name) {}
	function fetch($resource_name) {}
	function getTemplate () {}
}
