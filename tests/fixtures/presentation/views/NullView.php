<?php
namespace fixtures\presentation\views;
use vsc\presentation\views\ViewA;

class NullView extends ViewA {
	function append($tplVar, $value=null, $merge=false) {}
	function assign($tplVar, $value = null) {}
	function display($resourceName) {}
	function fetch($resourceName) {}
	function getTemplate () {
		return parent::getTemplate();
	}
}
