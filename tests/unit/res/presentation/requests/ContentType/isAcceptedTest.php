<?php
namespace tests\res\presentation\requests\ContentType;

use \vsc\presentation\requests\ContentType;
use \vsc\presentation\requests\ContentTypes;

/**
 * @covers \vsc\presentation\requests\ContentType::isAccepted()
 */
class isAccepted extends \BaseUnitTest
{
	public function testBasicIsAccepted()
	{
		$aContentTypes = array();
		$this->assertFalse(ContentType::isAccepted(ContentTypes::EVERYTHING, $aContentTypes));
		$this->assertFalse(ContentType::isAccepted(ContentTypes::IMAGE, $aContentTypes));
		$this->assertFalse(ContentType::isAccepted(ContentTypes::PNG, $aContentTypes));
		$this->assertFalse(ContentType::isAccepted(ContentTypes::GIF, $aContentTypes));
		$this->assertFalse(ContentType::isAccepted(ContentTypes::APPLICATION, $aContentTypes));
		$this->assertFalse(ContentType::isAccepted(ContentTypes::XML, $aContentTypes));
		$this->assertFalse(ContentType::isAccepted(ContentTypes::JSON, $aContentTypes));
		$this->assertFalse(ContentType::isAccepted(ContentTypes::TEXT, $aContentTypes));
		$this->assertFalse(ContentType::isAccepted(ContentTypes::CSS, $aContentTypes));
	}

	public function testValidContentTypes () {
		$aContentTypes = array(ContentTypes::EVERYTHING);
		$this->assertTrue(ContentType::isAccepted(ContentTypes::EVERYTHING, $aContentTypes));
		$this->assertTrue(ContentType::isAccepted(ContentTypes::IMAGE, $aContentTypes));
		$this->assertTrue(ContentType::isAccepted(ContentTypes::PNG, $aContentTypes));
		$this->assertTrue(ContentType::isAccepted(ContentTypes::GIF, $aContentTypes));
		$this->assertTrue(ContentType::isAccepted(ContentTypes::APPLICATION, $aContentTypes));
		$this->assertTrue(ContentType::isAccepted(ContentTypes::XML, $aContentTypes));
		$this->assertTrue(ContentType::isAccepted(ContentTypes::JSON, $aContentTypes));
		$this->assertTrue(ContentType::isAccepted(ContentTypes::TEXT, $aContentTypes));
		$this->assertTrue(ContentType::isAccepted(ContentTypes::CSS, $aContentTypes));

		$aContentTypes = array(ContentTypes::IMAGE);
		$this->assertFalse(ContentType::isAccepted(ContentTypes::EVERYTHING, $aContentTypes));
		$this->assertTrue(ContentType::isAccepted(ContentTypes::IMAGE, $aContentTypes));
		$this->assertTrue(ContentType::isAccepted(ContentTypes::PNG, $aContentTypes));
		$this->assertTrue(ContentType::isAccepted(ContentTypes::GIF, $aContentTypes));
		$this->assertFalse(ContentType::isAccepted(ContentTypes::APPLICATION, $aContentTypes));
		$this->assertFalse(ContentType::isAccepted(ContentTypes::XML, $aContentTypes));
		$this->assertFalse(ContentType::isAccepted(ContentTypes::JSON, $aContentTypes));
		$this->assertFalse(ContentType::isAccepted(ContentTypes::TEXT, $aContentTypes));
		$this->assertFalse(ContentType::isAccepted(ContentTypes::CSS, $aContentTypes));

		$aContentTypes = array(ContentTypes::PNG);
		$this->assertFalse(ContentType::isAccepted(ContentTypes::EVERYTHING, $aContentTypes));
		$this->assertFalse(ContentType::isAccepted(ContentTypes::IMAGE, $aContentTypes));
		$this->assertTrue(ContentType::isAccepted(ContentTypes::PNG, $aContentTypes));
		$this->assertFalse(ContentType::isAccepted(ContentTypes::GIF, $aContentTypes));
		$this->assertFalse(ContentType::isAccepted(ContentTypes::APPLICATION, $aContentTypes));
		$this->assertFalse(ContentType::isAccepted(ContentTypes::XML, $aContentTypes));
		$this->assertFalse(ContentType::isAccepted(ContentTypes::JSON, $aContentTypes));
		$this->assertFalse(ContentType::isAccepted(ContentTypes::TEXT, $aContentTypes));
		$this->assertFalse(ContentType::isAccepted(ContentTypes::CSS, $aContentTypes));

		$aContentTypes = array(ContentTypes::GIF);
		$this->assertFalse(ContentType::isAccepted(ContentTypes::EVERYTHING, $aContentTypes));
		$this->assertFalse(ContentType::isAccepted(ContentTypes::IMAGE, $aContentTypes));
		$this->assertFalse(ContentType::isAccepted(ContentTypes::PNG, $aContentTypes));
		$this->assertTrue(ContentType::isAccepted(ContentTypes::GIF, $aContentTypes));
		$this->assertFalse(ContentType::isAccepted(ContentTypes::APPLICATION, $aContentTypes));
		$this->assertFalse(ContentType::isAccepted(ContentTypes::XML, $aContentTypes));
		$this->assertFalse(ContentType::isAccepted(ContentTypes::JSON, $aContentTypes));
		$this->assertFalse(ContentType::isAccepted(ContentTypes::TEXT, $aContentTypes));
		$this->assertFalse(ContentType::isAccepted(ContentTypes::CSS, $aContentTypes));

		$aContentTypes = array(ContentTypes::APPLICATION);
		$this->assertFalse(ContentType::isAccepted(ContentTypes::EVERYTHING, $aContentTypes));
		$this->assertFalse(ContentType::isAccepted(ContentTypes::IMAGE, $aContentTypes));
		$this->assertFalse(ContentType::isAccepted(ContentTypes::PNG, $aContentTypes));
		$this->assertFalse(ContentType::isAccepted(ContentTypes::GIF, $aContentTypes));
		$this->assertTrue(ContentType::isAccepted(ContentTypes::APPLICATION, $aContentTypes));
		$this->assertTrue(ContentType::isAccepted(ContentTypes::XML, $aContentTypes));
		$this->assertTrue(ContentType::isAccepted(ContentTypes::JSON, $aContentTypes));
		$this->assertFalse(ContentType::isAccepted(ContentTypes::TEXT, $aContentTypes));
		$this->assertFalse(ContentType::isAccepted(ContentTypes::CSS, $aContentTypes));

		$aAcceptedContentTypes = array(ContentTypes::JSON);
		$this->assertFalse(ContentType::isAccepted(ContentTypes::EVERYTHING, $aAcceptedContentTypes));
		$this->assertFalse(ContentType::isAccepted(ContentTypes::APPLICATION, $aAcceptedContentTypes));
		$this->assertFalse(ContentType::isAccepted(ContentTypes::XML, $aAcceptedContentTypes));
		$this->assertTrue(ContentType::isAccepted(ContentTypes::JSON, $aAcceptedContentTypes));
		$this->assertFalse(ContentType::isAccepted(ContentTypes::IMAGE, $aAcceptedContentTypes));
		$this->assertFalse(ContentType::isAccepted(ContentTypes::PNG, $aAcceptedContentTypes));
		$this->assertFalse(ContentType::isAccepted(ContentTypes::GIF, $aAcceptedContentTypes));

		$aAcceptedContentTypes = array(ContentTypes::XML);
		$this->assertFalse(ContentType::isAccepted(ContentTypes::EVERYTHING, $aAcceptedContentTypes));
		$this->assertFalse(ContentType::isAccepted(ContentTypes::APPLICATION, $aAcceptedContentTypes));
		$this->assertTrue(ContentType::isAccepted(ContentTypes::XML, $aAcceptedContentTypes));
		$this->assertFalse(ContentType::isAccepted(ContentTypes::JSON, $aAcceptedContentTypes));
		$this->assertFalse(ContentType::isAccepted(ContentTypes::IMAGE, $aAcceptedContentTypes));
		$this->assertFalse(ContentType::isAccepted(ContentTypes::PNG, $aAcceptedContentTypes));
		$this->assertFalse(ContentType::isAccepted(ContentTypes::GIF, $aAcceptedContentTypes));
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
