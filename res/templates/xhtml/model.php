<?php
foreach ($mValue as $sName => $mValue) {
	$sType = gettype($mValue);
	echo '<dt>'. $sName . ' ['.($sType != 'object' ? $sType : get_class($mValue)).'] </dt>'."\n";
	if ($mValue instanceof Iterator || is_array($mValue)) {
		echo '<dl>'."\n";
		include (__FILE__);
		echo '</dl>'."\n";
	} else {
		echo '<dd> Value: ' . $mValue . '</dd>'."\n";
	}
}
