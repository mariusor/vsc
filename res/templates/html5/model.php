<?php
/* @var $this vscViewA */
foreach ($model->toArray() as $sName => $mValue) {
	if (is_scalar($mValue)) {
		echo '<li><strong>' . $sName.'</strong> ➞ '."\n";
		echo $mValue.'</li>'."\n";
		continue;
	} /**/elseif (is_array($mValue)) {
		$mValue = new vscArrayModel ($mValue);
	}

	if (vscModelA::isValid($mValue)) {
		$this->setModel ($mValue);
		echo '<li> <strong>'.(is_int($sName) ? '#' : '').$sName.'</strong> [' . get_class ($mValue) . '] '.(isset($mValue->length) ? ' (' . $mValue->length . ')' : '')."\n";
		echo '<ul>'."\n";
		echo $this->fetch (__FILE__);
		echo '</ul></li>'."\n";
		continue;
	}

	echo '<li> <strong>'.$sName.'</strong> ➞ '."\n";
	echo var_export ($mValue, true).'</li>'."\n";
}