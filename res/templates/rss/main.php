<?php /* @var $this vscRssView */ ?>
<?php echo '<?xml version="1.0" encoding="utf-8"?>'; ?>
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
	<channel>
		<atom:link href="<?php echo self::getCurrentUri(); ?>" rel="self" type="application/rss+xml" />
		<title><?php echo $this->getTitle(); ?></title>
		<link><?php echo self::getCurrentSiteUri(); ?></link>
		<description><?php echo $this->getDescription() ?></description>
		<language><?php echo $this->getLanguage() ?></language>
		<lastBuildDate><?php echo $this->getLastBuildDate() ?></lastBuildDate>
		<docs>http://blogs.law.harvard.edu/tech/rss</docs>
<?php
try {
	$sContent = $this->fetch ($this->getTemplate());
} catch (vscExceptionPath $e) {
	// the template could not be found
}
	if (!empty($sContent)) {
		echo $sContent;
	} else {
		include ('content.php');
	}
?>

	</channel>
</rss>