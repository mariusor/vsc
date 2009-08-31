<?php
/**
 * this will be linked from the snaptest/addons folder
 */
$config['name'] = 'Vsc addon';
$config['version'] = '0.1';
$config['author'] = 'hab';
$config['description'] = '';
include_once ('core/reporter/reporter.php');
include_once ('core/reporter/reporters/text.php');
include_once ('core/reporter/reporters/phpserializer.php');
set_include_path (realpath ('../vsc_v2/') . PATH_SEPARATOR . get_include_path());
include ('vsc.inc.php');
