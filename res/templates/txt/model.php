<?php
/* @var $this vscTxtViewA */
foreach ($model->toArray() as $sName => $mValue) {
	if (is_scalar($mValue)) {
		echo $sName.' ➞ '."\n";
		echo $mValue.''."\n";
		continue;
	} /**/elseif (is_array($mValue)) {
		$mValue = new vscArrayModel ($mValue);
	}

	if ($mValue instanceof vscModelA) {
		$this->setModel ($mValue);
		echo ' '.(is_int($sName) ? '#' : '').$sName.' [' . get_class ($mValue) . '] '.(isset($mValue->length) ? ' (' . $mValue->length . ')' : '')."\n";
		echo "\n";
		echo $this->fetch (__FILE__);
		echo "\n";
		continue;
	}

	echo $sName.' ➞ '."\n";
	echo var_export ($mValue, true).''."\n";
}
