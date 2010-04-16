<?php
/* @var $this vscTxtViewA */
foreach ($model->toArray() as $sName => $mValue) {
	if (is_scalar($mValue)) {
		vscString::_echo ("\t", $GLOBALS['depth']);
		echo $sName.' = ';
		echo $mValue . "\n";
		continue;
	} elseif (is_array($mValue)) {
		$mValue = new vscArrayModel ($mValue);
	}

	if ($mValue instanceof vscModelA) {
		$this->setModel ($mValue);
		vscString::_echo ("\t", $GLOBALS['depth']);
		echo (is_int($sName) ? '#' : '').$sName.' [' . get_class ($mValue) . '] '.(isset($mValue->length) ? ' (' . $mValue->length . ')' : ''). "\n";
		$GLOBALS['depth']++;
		echo $this->fetch (__FILE__);
		echo "\n";
		$GLOBALS['depth']--;
		continue;
	}

	vscString::_echo ("\t", $GLOBALS['depth']);
	echo $sName.' = ';
	echo var_export ($mValue, true)."\n";
}
