<?php /* @var $this \vsc\presentation\views\vscJsonView  */
use vsc\vscException;

try {
	$GLOBALS['depth'] = 1;
	echo '{'."\n";
	echo "\t" . '"' . get_class($this->getModel()) . '":  { '."\n";
	echo $this->fetch (dirname(__FILE__) . '/model.php');
	echo "\t" . '}'."\n";
	echo '}'."\n";
} catch (vscException $e) {
	\vsc\d ($e);
}

