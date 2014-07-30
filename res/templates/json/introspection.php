<?php
/* @var \vsc\domain\models\vscModelA $model */
$t = array();

foreach ($model as $key => $data) {
	$t[] = array(
		'method_name' => $key,
		'method_description' => $data
	);
}

echo $this->outputModel ($t);
