<?php /* @var $this \vsc\presentation\views\vscHtml5View */ ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
<?php
if (count($this->getMetaHeaders()) >= 1) {
	foreach ($this->getMetaHeaders() as $sName => $sValue) { ?>
	<meta <?php echo 'name="'.$sName .'" content="'.$sValue.'"'; ?> />
<?php
	}
}

$aAllScripts = $this->getScripts(true);
if (count ($aAllScripts) >= 1 ) {
	foreach ($aAllScripts as $sPath) {
?>
	<script type="text/javascript" src="<?php echo $sPath?>"> </script>
<?php
	}
}

$aAllStyles = $this->getStyles ();
if (count($aAllStyles) >= 1) {
	foreach ($aAllStyles as $sMedia => $aStyles) {
		if (is_array($aStyles)) {
			foreach ($aStyles as $sPath ) {
				echo "\t".'<link rel="stylesheet" href="' . $sPath . '"' . ($sMedia ? ' media="'. $sMedia.'"' : '') . " />\n";
			}
		}
	}
}

if (is_array ($this->getLinks()) && count($this->getLinks()) >= 1) {
	foreach ($this->getLinks() as $sType => $aLinkContent) {
		foreach ($aLinkContent as $aValue) {
			echo "\t".'<link type="' . $sType .'" ';
			foreach ($aValue as $sKey => $sValue) {
				echo $sKey . '="' . $sValue . '" ';
			}
			echo '/>'."\n";
		}
	}
}
?>
	<title><?php $sTitle = $this->getTitle(); echo ($sTitle ? $sTitle : '[null]') ?></title>
</head>
<body>
	<!-- hic sunt leones -->

<?php
try {
	$sContent = $this->fetch ($this->getTemplate());
} catch (\vsc\vscExceptionPath $e) {
	// the template could not be found
}
	if (!empty($sContent)) {
		echo $sContent;
	} else {
		echo $this->fetch(dirname(__FILE__) . '/content.php');
	}
?>

	<!-- /hic sunt leones -->
<?php
$aAllScripts = $this->getScripts();
if (count ($aAllScripts) >= 1 ) {
	foreach ($aAllScripts as $sPath) {
?>
<script type="text/javascript" src="<?php echo $sPath;?>"> </script>
<?php
	}
}
?>
</body>
</html>
