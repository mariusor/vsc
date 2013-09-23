<?php
$BASE_PATH = dirname(__FILE__) . '/';

/* @var $this vscRwSiteMap */
$this->getCurrentModuleMap()->setTemplatePath($BASE_PATH);
$oMap = $this->map ('test\Z', $BASE_PATH . 'test.class.php');
