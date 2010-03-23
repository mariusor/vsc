<?php /* @var $this vscRssView */ ?>
<?php echo '<?xml version="1.0" encoding="utf-8"?>'; ?>
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
	<channel>
		<atom:link href="<?php echo $this->getUrl() ?>" rel="self" type="application/rss+xml" />
		<title><?php echo $this->getTitle() ?></title>
		<link><?php echo $this->getUrl() ?></link>
		<description><?php echo $this->getDescription() ?></description>
		<language><?php echo $this->getLanguage() ?></language>
		<lastBuildDate><?php echo $this->getLastBuildDate() ?></lastBuildDate>
		<docs>http://blogs.law.harvard.edu/tech/rss</docs>
		<?php echo $this->getContent(); ?>

	</channel>
</rss>