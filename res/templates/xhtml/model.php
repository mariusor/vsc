<?php
use \vsc\domain\models\ModelA;
use \vsc\domain\models\ArrayModel;
/* @var ModelA $model */

if (ModelA::isValid($model)) {
	/* @var $this \vsc\presentation\views\ViewA */
	foreach ($model->toArray() as $sName => $mValue) {
		if (is_scalar($mValue)) {
			echo '<li><strong>'.$sName.'</strong> ➞ '."\n";
			echo $mValue.'</li>'."\n";
			continue;
		} /**/elseif (is_array($mValue)) {
			$mValue = new ArrayModel($mValue);
		}

		if (ModelA::isValid($mValue)) {
			$this->setModel($mValue);
			echo '<li> <strong>'.(is_int($sName) ? '#' : '').$sName.'</strong> ['.get_class($mValue).'] '.(isset($mValue->length) ? ' ('.$mValue->length.')' : '')."\n";
			echo '<ul>'."\n";
			echo $this->fetch(__FILE__);
			echo '</ul></li>'."\n";
			continue;
		}

		echo '<li> <strong>'.$sName.'</strong> ➞ '."\n";
		echo var_export($mValue, true).'</li>'."\n";
	}
}
