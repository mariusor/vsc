<?php /* @var $this vscJsonViewA  */ 
try {
	echo '{'."\n";
	echo '"' . get_class($this->getModel()) . '" : '."\n";
	echo $this->fetch (dirname(__FILE__) . '/model.php');
	echo '}'."\n";
} catch (vscException $e) {
	d ($e);
}

