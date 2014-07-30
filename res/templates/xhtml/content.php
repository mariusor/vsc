<?php
use vsc\infrastructure\vsc;
/* @var $this \vsc\presentation\views\vscViewA  */ ?>
<h2>Default XHTML template</h2>
<div> This is the default XHTML template from the <?php echo vsc::name(); ?> framework.<br/>
In order to add content, you need to:
<ol>
	<li>add the <strong><?php echo $this->getViewFolder() ?></strong> folder in your module's template folder: <pre><?php echo $this->getMap()->getTemplatePath(); ?></pre></li>
	<li>add the default template <pre><?php echo $this->getTemplate(); ?></pre></li>
</ol>
These settings are defined in the following file:
<ul>
<?php
	foreach (get_included_files() as $sFileName) {
		if (stristr($sFileName, 'map.php') && stristr ($sFileName, $this->getMap()->getModuleName()))
			echo '<li>' . $sFileName . '</li>';
	};
?>
</ul>
<?php /**/ ?>The matching regular expression for the current URI is: <pre> <?php echo $this->getMap()->getRegex(); ?> =&gt; <?php echo $this->getMap()->getPath(); ?> </pre> <?php /**/ ?>
<?php
try {
	echo '<ul>'."\n";
	echo '<li style="list-style:none; margin-left:-2em">Model type: <strong>' . get_class($this->getModel()) . '</strong></li>'."\n";
	echo $this->fetch (dirname(__FILE__) . '/model.php');
	echo '</ul>'."\n";
} catch (\vsc\vscException $f) {
	//d ($f);
}
?>
</div>

