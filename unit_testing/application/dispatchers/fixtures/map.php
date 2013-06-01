<?php
/* @var $this vscRwSiteMap */
$this->getCurrentModuleMap()->setTemplatePath(dirname(__FILE__));
$oMap = $this->map ('test\Z', BASE_PATH . 'test.class.php');

