<?php
namespace tests\res\presentation\requests\ContentType;

use \vsc\presentation\requests\ContentType;
use \vsc\presentation\requests\ContentTypes;

/**
 * @covers \vsc\presentation\requests\ContentType::isAccepted()
 */
class isAccepted extends \PHPUnit_Framework_TestCase
{
	public function testBasicIsAccepted()
	{
		$aContentTypes = array();
		$this->assertFalse(ContentType::isAccepted(ContentTypes::Everything, $aContentTypes));
		$this->assertFalse(ContentType::isAccepted(ContentTypes::Image, $aContentTypes));
		$this->assertFalse(ContentType::isAccepted(ContentTypes::Png, $aContentTypes));
		$this->assertFalse(ContentType::isAccepted(ContentTypes::Gif, $aContentTypes));
		$this->assertFalse(ContentType::isAccepted(ContentTypes::Application, $aContentTypes));
		$this->assertFalse(ContentType::isAccepted(ContentTypes::Xml, $aContentTypes));
		$this->assertFalse(ContentType::isAccepted(ContentTypes::Json, $aContentTypes));
		$this->assertFalse(ContentType::isAccepted(ContentTypes::Text, $aContentTypes));
		$this->assertFalse(ContentType::isAccepted(ContentTypes::Css, $aContentTypes));
	}

	public function testValidContentTypes () {
		$aContentTypes = array(ContentTypes::Everything);
		$this->assertTrue(ContentType::isAccepted(ContentTypes::Everything, $aContentTypes));
		$this->assertTrue(ContentType::isAccepted(ContentTypes::Image, $aContentTypes));
		$this->assertTrue(ContentType::isAccepted(ContentTypes::Png, $aContentTypes));
		$this->assertTrue(ContentType::isAccepted(ContentTypes::Gif, $aContentTypes));
		$this->assertTrue(ContentType::isAccepted(ContentTypes::Application, $aContentTypes));
		$this->assertTrue(ContentType::isAccepted(ContentTypes::Xml, $aContentTypes));
		$this->assertTrue(ContentType::isAccepted(ContentTypes::Json, $aContentTypes));
		$this->assertTrue(ContentType::isAccepted(ContentTypes::Text, $aContentTypes));
		$this->assertTrue(ContentType::isAccepted(ContentTypes::Css, $aContentTypes));

		$aContentTypes = array(ContentTypes::Image);
		$this->assertFalse(ContentType::isAccepted(ContentTypes::Everything, $aContentTypes));
		$this->assertTrue(ContentType::isAccepted(ContentTypes::Image, $aContentTypes));
		$this->assertTrue(ContentType::isAccepted(ContentTypes::Png, $aContentTypes));
		$this->assertTrue(ContentType::isAccepted(ContentTypes::Gif, $aContentTypes));
		$this->assertFalse(ContentType::isAccepted(ContentTypes::Application, $aContentTypes));
		$this->assertFalse(ContentType::isAccepted(ContentTypes::Xml, $aContentTypes));
		$this->assertFalse(ContentType::isAccepted(ContentTypes::Json, $aContentTypes));
		$this->assertFalse(ContentType::isAccepted(ContentTypes::Text, $aContentTypes));
		$this->assertFalse(ContentType::isAccepted(ContentTypes::Css, $aContentTypes));

		$aContentTypes = array(ContentTypes::Png);
		$this->assertFalse(ContentType::isAccepted(ContentTypes::Everything, $aContentTypes));
		$this->assertFalse(ContentType::isAccepted(ContentTypes::Image, $aContentTypes));
		$this->assertTrue(ContentType::isAccepted(ContentTypes::Png, $aContentTypes));
		$this->assertFalse(ContentType::isAccepted(ContentTypes::Gif, $aContentTypes));
		$this->assertFalse(ContentType::isAccepted(ContentTypes::Application, $aContentTypes));
		$this->assertFalse(ContentType::isAccepted(ContentTypes::Xml, $aContentTypes));
		$this->assertFalse(ContentType::isAccepted(ContentTypes::Json, $aContentTypes));
		$this->assertFalse(ContentType::isAccepted(ContentTypes::Text, $aContentTypes));
		$this->assertFalse(ContentType::isAccepted(ContentTypes::Css, $aContentTypes));

		$aContentTypes = array(ContentTypes::Gif);
		$this->assertFalse(ContentType::isAccepted(ContentTypes::Everything, $aContentTypes));
		$this->assertFalse(ContentType::isAccepted(ContentTypes::Image, $aContentTypes));
		$this->assertFalse(ContentType::isAccepted(ContentTypes::Png, $aContentTypes));
		$this->assertTrue(ContentType::isAccepted(ContentTypes::Gif, $aContentTypes));
		$this->assertFalse(ContentType::isAccepted(ContentTypes::Application, $aContentTypes));
		$this->assertFalse(ContentType::isAccepted(ContentTypes::Xml, $aContentTypes));
		$this->assertFalse(ContentType::isAccepted(ContentTypes::Json, $aContentTypes));
		$this->assertFalse(ContentType::isAccepted(ContentTypes::Text, $aContentTypes));
		$this->assertFalse(ContentType::isAccepted(ContentTypes::Css, $aContentTypes));

		$aContentTypes = array(ContentTypes::Application);
		$this->assertFalse(ContentType::isAccepted(ContentTypes::Everything, $aContentTypes));
		$this->assertFalse(ContentType::isAccepted(ContentTypes::Image, $aContentTypes));
		$this->assertFalse(ContentType::isAccepted(ContentTypes::Png, $aContentTypes));
		$this->assertFalse(ContentType::isAccepted(ContentTypes::Gif, $aContentTypes));
		$this->assertTrue(ContentType::isAccepted(ContentTypes::Application, $aContentTypes));
		$this->assertTrue(ContentType::isAccepted(ContentTypes::Xml, $aContentTypes));
		$this->assertTrue(ContentType::isAccepted(ContentTypes::Json, $aContentTypes));
		$this->assertFalse(ContentType::isAccepted(ContentTypes::Text, $aContentTypes));
		$this->assertFalse(ContentType::isAccepted(ContentTypes::Css, $aContentTypes));

		$aAcceptedContentTypes = array(ContentTypes::Json);
		$this->assertFalse(ContentType::isAccepted(ContentTypes::Everything, $aAcceptedContentTypes));
		$this->assertFalse(ContentType::isAccepted(ContentTypes::Application, $aAcceptedContentTypes));
		$this->assertFalse(ContentType::isAccepted(ContentTypes::Xml, $aAcceptedContentTypes));
		$this->assertTrue(ContentType::isAccepted(ContentTypes::Json, $aAcceptedContentTypes));
		$this->assertFalse(ContentType::isAccepted(ContentTypes::Image, $aAcceptedContentTypes));
		$this->assertFalse(ContentType::isAccepted(ContentTypes::Png, $aAcceptedContentTypes));
		$this->assertFalse(ContentType::isAccepted(ContentTypes::Gif, $aAcceptedContentTypes));

		$aAcceptedContentTypes = array(ContentTypes::Xml);
		$this->assertFalse(ContentType::isAccepted(ContentTypes::Everything, $aAcceptedContentTypes));
		$this->assertFalse(ContentType::isAccepted(ContentTypes::Application, $aAcceptedContentTypes));
		$this->assertTrue(ContentType::isAccepted(ContentTypes::Xml, $aAcceptedContentTypes));
		$this->assertFalse(ContentType::isAccepted(ContentTypes::Json, $aAcceptedContentTypes));
		$this->assertFalse(ContentType::isAccepted(ContentTypes::Image, $aAcceptedContentTypes));
		$this->assertFalse(ContentType::isAccepted(ContentTypes::Png, $aAcceptedContentTypes));
		$this->assertFalse(ContentType::isAccepted(ContentTypes::Gif, $aAcceptedContentTypes));
	}

	public function testIsAcceptedWithPriorities() {
		$Everything = '*/*';
		$Image = 'image/*';
		$Png = 'image/png';
		$Gif = 'image/gif';
		$Application = 'application/*';
		$Xml = 'application/xml';
		$Json = 'application/json';

		$aAcceptedContentTypes = array('application/json;q=0.9');
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
