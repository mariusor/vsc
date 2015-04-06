<?php
use \vsc\domain\models\ArrayModel;
use \vsc\infrastructure\StringUtils;
use \vsc\domain\models\ModelA;
/* @var ModelA $model */

/* @var $this \vsc\presentation\views\TxtView */
foreach ($model->toArray() as $sName => $mValue) {
	if (is_scalar($mValue)) {
		StringUtils::_echo("\t", $GLOBALS['depth']);
		echo $sName.' = ';
		echo $mValue."\n";
		continue;
	} elseif (is_array($mValue)) {
		$mValue = new ArrayModel($mValue);
	}

	if (ModelA::isValid($mValue)) {
		$this->setModel($mValue);
		StringUtils::_echo("\t", $GLOBALS['depth']);
		echo (is_int($sName) ? '#' : '').$sName.' ['.get_class($mValue).'] '.(isset($mValue->length) ? ' ('.$mValue->length.')' : '')."\n";
		$GLOBALS['depth']++;
		echo $this->fetch(__FILE__);
		echo "\n";
		$GLOBALS['depth']--;
		continue;
	}

	StringUtils::_echo("\t", $GLOBALS['depth']);
	echo $sName.' = ';
	echo var_export($mValue, true)."\n";
}
