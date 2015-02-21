<?php
use vsc\ExceptionPath;
/* @var $this \vsc\presentation\views\JsonView */
try {
	$sContent = $this->fetch($this->getTemplate());
} catch (ExceptionPath $e) {
	// the template could not be found
}
if (!empty($sContent)) {
	echo $sContent;
} else {
	echo $this->fetch(dirname(__FILE__).'/content.tpl.php');
}
