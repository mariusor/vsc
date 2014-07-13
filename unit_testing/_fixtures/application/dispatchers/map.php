<?php


/* @var $this vscRwSiteMap */
$this->getCurrentModuleMap()->setTemplatePath(VSC_FIXTURE_PATH . 'templates' . DIRECTORY_SEPARATOR );
$oMap = $this->map ('test\Z', VSC_FIXTURE_PATH . 'application' . DIRECTORY_SEPARATOR . 'processors' . DIRECTORY_SEPARATOR . 'testfixtureprocessor.class.php');
