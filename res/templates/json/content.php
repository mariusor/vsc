<?php /* @var $this \vsc\presentation\views\JsonView  */
use vsc\Exception;
use vsc\infrastructure\vsc;

try {
	$GLOBALS['depth'] = 1;
	echo '{'."\n";
	echo "\t" . '"' . get_class($this->getModel()) . '":  { '."\n";
	echo $this->fetch (dirname(__FILE__) . '/model.php');
	echo "\t" . '}'."\n";
	echo '}'."\n";
} catch (Exception $e) {
	vsc::d ($e);
}

