<?php
use vsc\infrastructure\vscString;
use vsc\domain\models\vscArrayModel;
use vsc\domain\models\vscModelA;
/* @var vscModelA $model */

/* @var $this \vsc\presentation\views\vscJsonView  */
$aArray = $model->toArray();
$mEnd = end ($aArray);
$sEndKey = key ($aArray);
foreach ($aArray as $sName => $mValue) {
	if (is_scalar($mValue)) {
		vscString::_echo ("\t", $GLOBALS['depth']);
		if (!is_int($sName)) echo '"' . $sName.'": ';
		echo '"' . vscString::stripEntities(str_replace('"','\"', $mValue)). '"' . ($sName != $sEndKey ? ',' : '') . "\n";

		continue;
	} /**/elseif (is_array($mValue)) {
		$mValue = new vscArrayModel ($mValue);
	}

	if (vscModelA::isValid($mValue)) {
		$this->setModel ($mValue);
		vscString::_echo ("\t", $GLOBALS['depth']);
		echo '"'.$sName.'": ';
		echo '{'."\n";
		$GLOBALS['depth']++;
		echo $this->fetch (__FILE__);
		vscString::_echo ("\t", $GLOBALS['depth']-1);
		echo '}' . ($sName != $sEndKey && $mEnd != $mValue ? ',' : '') . "\n";
		$GLOBALS['depth']--;
		continue;
	}

	vscString::_echo ("\t", $GLOBALS['depth']);
	echo '"'.$sName.'" : ';
	echo '"' . var_export ($mValue, true).'"' . ($sName != $sEndKey ? ',' : '') . "\n";
}
