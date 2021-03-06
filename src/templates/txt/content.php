<?php
use vsc\infrastructure\StringUtils;
use vsc\infrastructure\vsc;
use \vsc\Exception;

/* @var $this \vsc\presentation\views\PlainTextView  */ ?>
Default TXT template

This is the default txt template from the <?php echo StringUtils::stripTags(vsc::name()); ?> framework.
In order to add content, you need to:

	- add the <?php echo $this->getViewFolder() ?> folder in your module's template folder: <?php echo $this->getMap()->getTemplatePath(); ?>

	- add the default template <?php echo $this->getTemplate(); ?>


These settings are defined in one of the following files:

<?php
	foreach (get_included_files() as $sFileName) {
		if (stristr($sFileName, 'map.php') && stristr($sFileName, $this->getMap()->getModuleName()))
			echo "\t" . '- ' . $sFileName . "\n";
	};
?>

<?php /**/ ?>The matching regular expression for the current URI is:  <?php echo $this->getMap()->getRegex(); ?> => <?php echo $this->getMap()->getPath(); ?>  <?php /**/ ?>

<?php
try {
	$GLOBALS['depth'] = 0;
	echo "\n";
	echo 'Model type: ' . get_class($this->getModel()) . "\n";
	echo $this->fetch(dirname(__FILE__) . '/model.php');
	echo "\n";
} catch (Exception $e) {
	vsc::d($e);
}
?>
