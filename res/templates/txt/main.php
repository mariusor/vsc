<?php
use vsc\vscExceptionPath;
/* @var $this \vsc\presentation\views\vscTxtView */

try {
	$sContent = $this->fetch ($this->getTemplate());
} catch (vscExceptionPath $e) {
	// the template could not be found
}
if (!empty($sContent)) {
	echo $sContent;
} else {
	echo $this->fetch(dirname(__FILE__) . '/content.php');
}

