<?php
/* @var $this \vsc\presentation\views\RssView */
/* @var $item \vsc\domain\domain\RssItem */
use vsc\infrastructure\vsc;
?>
		<item>
			<title>Default RSS template</title>
			<link><?php echo $this->getCurrentUri(); ?></link>
			<author><?php echo 'admin@'.$_SERVER['HTTP_HOST']; ?></author>
			<description><![CDATA[ This is the default RSS template from the <?php echo vsc::name(); ?> framework.<br/>
In order to add content, you need to:
<ol>
	<li>add the <strong><?php echo $this->getViewFolder() ?></strong> folder in your module's template folder: <pre><?php echo $this->getMap()->getTemplatePath(); ?></pre></li>
	<li>add the default template <pre><?php echo $this->getTemplate(); ?></pre></li>
</ol>
These settings are defined in one of the following files:
<ul>
<?php
	foreach (get_included_files() as $sFileName) {
		if (stristr($sFileName, 'map.php') && stristr($sFileName, $this->getMap()->getModuleName()))
			echo '<li>'.$sFileName.'</li>';
	};
?>
</ul>
<?php /**/ ?>The matching regular expression for the current URI is: <pre> <?php echo $this->getMap()->getRegex(); ?> => <?php echo $this->getMap()->getPath(); ?> </pre> <?php /**/ ?>
<?php
echo 'Model type: <strong>'.get_class($this->getModel()).'</strong>';
echo '<dl>'."\n";
echo $this->fetch(dirname(__FILE__).'/model.php');
echo '</dl>'."\n";
?>
			]]> </description>
			<pubDate><?php echo date('r', $item['post_date']); ?></pubDate>
			<guid isPermaLink='false'><?php echo sha1($item['content']); ?></guid>
		</item>
