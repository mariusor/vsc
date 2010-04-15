<?php
/* @var $this vscJsonViewA */
foreach ($model->toArray() as $sName => $mValue) {
	if (is_scalar($mValue)) {
		echo '"' . $sName.'" : ';
		echo '"' . $mValue.'"'."\n";
		continue;
	} /**/elseif (is_array($mValue)) {
		$mValue = new vscArrayModel ($mValue);
	}

	if ($mValue instanceof vscModelA) {
		$this->setModel ($mValue);
		echo (!is_int($sName) ? '"'.$sName.'"' : $sName).' : ';
		echo '{'."\n";
		echo $this->fetch (__FILE__);
		echo '}'."\n";
		continue;
	}

	echo '"'.$sName.'" : ';
	echo '"' . var_export ($mValue, true).'"'."\n";
}
