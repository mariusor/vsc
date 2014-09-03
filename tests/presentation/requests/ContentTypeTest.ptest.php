<?php

use vsc\presentation\requests\ContentType;

class ContentTypeTest extends PHPUnit_Framework_TestCase {

	public function setUp () {
	}

	public function tearDown () {
	}

	public function testIsAccepted() {
		$Everything = '*/*';
		$Image = 'image/*';
		$Png = 'image/png';
		$Gif = 'image/gif';
		$Application = 'application/*';
		$Xml = 'application/xml';
		$Json = 'application/json';

		$aAcceptedContentTypes = array($Png);
		$this->assertFalse(ContentType::isAccepted($Everything, $aAcceptedContentTypes));
		$this->assertFalse(ContentType::isAccepted($Application, $aAcceptedContentTypes));
		$this->assertFalse(ContentType::isAccepted($Xml, $aAcceptedContentTypes));
		$this->assertFalse(ContentType::isAccepted($Json, $aAcceptedContentTypes));
		$this->assertFalse(ContentType::isAccepted($Image, $aAcceptedContentTypes));
		$this->assertTrue(ContentType::isAccepted($Png, $aAcceptedContentTypes));
		$this->assertFalse(ContentType::isAccepted($Gif, $aAcceptedContentTypes));

		$aAcceptedContentTypes = array($Gif);
		$this->assertFalse(ContentType::isAccepted($Everything, $aAcceptedContentTypes));
		$this->assertFalse(ContentType::isAccepted($Application, $aAcceptedContentTypes));
		$this->assertFalse(ContentType::isAccepted($Xml, $aAcceptedContentTypes));
		$this->assertFalse(ContentType::isAccepted($Json, $aAcceptedContentTypes));
		$this->assertFalse(ContentType::isAccepted($Image, $aAcceptedContentTypes));
		$this->assertFalse(ContentType::isAccepted($Png, $aAcceptedContentTypes));
		$this->assertTrue(ContentType::isAccepted($Gif, $aAcceptedContentTypes));

		$aAcceptedContentTypes = array($Image);
		$this->assertFalse(ContentType::isAccepted($Everything, $aAcceptedContentTypes));
		$this->assertFalse(ContentType::isAccepted($Application, $aAcceptedContentTypes));
		$this->assertFalse(ContentType::isAccepted($Xml, $aAcceptedContentTypes));
		$this->assertFalse(ContentType::isAccepted($Json, $aAcceptedContentTypes));
		$this->assertTrue(ContentType::isAccepted($Image, $aAcceptedContentTypes));
		$this->assertTrue(ContentType::isAccepted($Png, $aAcceptedContentTypes));
		$this->assertTrue(ContentType::isAccepted($Gif, $aAcceptedContentTypes));

		$aAcceptedContentTypes = array($Application);
		$this->assertFalse(ContentType::isAccepted($Everything, $aAcceptedContentTypes));
		$this->assertTrue(ContentType::isAccepted($Application, $aAcceptedContentTypes));
		$this->assertTrue(ContentType::isAccepted($Xml, $aAcceptedContentTypes));
		$this->assertTrue(ContentType::isAccepted($Json, $aAcceptedContentTypes));
		$this->assertFalse(ContentType::isAccepted($Image, $aAcceptedContentTypes));
		$this->assertFalse(ContentType::isAccepted($Png, $aAcceptedContentTypes));
		$this->assertFalse(ContentType::isAccepted($Gif, $aAcceptedContentTypes));

		$aAcceptedContentTypes = array($Json);
		$this->assertFalse(ContentType::isAccepted($Everything, $aAcceptedContentTypes));
		$this->assertFalse(ContentType::isAccepted($Application, $aAcceptedContentTypes));
		$this->assertFalse(ContentType::isAccepted($Xml, $aAcceptedContentTypes));
		$this->assertTrue(ContentType::isAccepted($Json, $aAcceptedContentTypes));
		$this->assertFalse(ContentType::isAccepted($Image, $aAcceptedContentTypes));
		$this->assertFalse(ContentType::isAccepted($Png, $aAcceptedContentTypes));
		$this->assertFalse(ContentType::isAccepted($Gif, $aAcceptedContentTypes));

		$aAcceptedContentTypes = array($Xml);
		$this->assertFalse(ContentType::isAccepted($Everything, $aAcceptedContentTypes));
		$this->assertFalse(ContentType::isAccepted($Application, $aAcceptedContentTypes));
		$this->assertTrue(ContentType::isAccepted($Xml, $aAcceptedContentTypes));
		$this->assertFalse(ContentType::isAccepted($Json, $aAcceptedContentTypes));
		$this->assertFalse(ContentType::isAccepted($Image, $aAcceptedContentTypes));
		$this->assertFalse(ContentType::isAccepted($Png, $aAcceptedContentTypes));
		$this->assertFalse(ContentType::isAccepted($Gif, $aAcceptedContentTypes));

		$aAcceptedContentTypes = array($Everything);
		$this->assertTrue(ContentType::isAccepted($Everything, $aAcceptedContentTypes));
		$this->assertTrue(ContentType::isAccepted($Application, $aAcceptedContentTypes));
		$this->assertTrue(ContentType::isAccepted($Xml, $aAcceptedContentTypes));
		$this->assertTrue(ContentType::isAccepted($Json, $aAcceptedContentTypes));
		$this->assertTrue(ContentType::isAccepted($Image, $aAcceptedContentTypes));
		$this->assertTrue(ContentType::isAccepted($Png, $aAcceptedContentTypes));
		$this->assertTrue(ContentType::isAccepted($Gif, $aAcceptedContentTypes));

		$aAcceptedContentTypes = array($Json.';q=0.9');
		$this->assertFalse(ContentType::isAccepted($Everything, $aAcceptedContentTypes));
		$this->assertFalse(ContentType::isAccepted($Application, $aAcceptedContentTypes));
		$this->assertFalse(ContentType::isAccepted($Xml, $aAcceptedContentTypes));
		$this->assertTrue(ContentType::isAccepted($Json, $aAcceptedContentTypes));
		$this->assertFalse(ContentType::isAccepted($Image, $aAcceptedContentTypes));
		$this->assertFalse(ContentType::isAccepted($Png, $aAcceptedContentTypes));
		$this->assertFalse(ContentType::isAccepted($Gif, $aAcceptedContentTypes));

		$aAcceptedContentTypes = array('text/html;q=0.9','application/xml;q=0.8');
		$this->assertFalse(ContentType::isAccepted($Everything, $aAcceptedContentTypes));
		$this->assertFalse(ContentType::isAccepted($Application, $aAcceptedContentTypes));
		$this->assertTrue(ContentType::isAccepted($Xml, $aAcceptedContentTypes));
		$this->assertTrue(ContentType::isAccepted('text/html', $aAcceptedContentTypes));
		$this->assertFalse(ContentType::isAccepted($Json, $aAcceptedContentTypes));
		$this->assertFalse(ContentType::isAccepted($Image, $aAcceptedContentTypes));
		$this->assertFalse(ContentType::isAccepted($Png, $aAcceptedContentTypes));
		$this->assertFalse(ContentType::isAccepted($Gif, $aAcceptedContentTypes));
	}
}
 