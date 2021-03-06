<?php
use vsc\infrastructure\StringUtils;
use vsc\domain\models\ArrayModel;
use vsc\domain\models\ModelA;
/* @var ModelA $model */

/* @var $this \vsc\presentation\views\JsonView  */
$aArray = $model->toArray();
$mEnd = end($aArray);
$sEndKey = key($aArray);
foreach ($aArray as $sName => $mValue) {
	if (is_scalar($mValue)) {
		StringUtils::_echo("\t", $GLOBALS['depth']);
		if (!is_int($sName)) {
			echo '"' . $sName . '": ';
		}
		echo '"' . StringUtils::stripEntities(str_replace('"', '\"', $mValue)) . '"' . ($sName != $sEndKey ? ',' : '') . "\n";

		continue;
	} /**/elseif (is_array($mValue)) {
		$mValue = new ArrayModel($mValue);
	}

	if (ModelA::isValid($mValue)) {
		$this->setModel($mValue);
		StringUtils::_echo("\t", $GLOBALS['depth']);
		echo '"' . $sName . '": ';
		echo '{' . "\n";
		$GLOBALS['depth']++;
		echo $this->fetch(__FILE__);
		StringUtils::_echo("\t", $GLOBALS['depth'] - 1);
		echo '}' . ($sName != $sEndKey && $mEnd != $mValue ? ',' : '') . "\n";
		$GLOBALS['depth']--;
		continue;
	}

	StringUtils::_echo("\t", $GLOBALS['depth']);
	echo '"' . $sName . '" : ';
	echo '"' . var_export($mValue, true) . '"' . ($sName != $sEndKey ? ',' : '') . "\n";
}
