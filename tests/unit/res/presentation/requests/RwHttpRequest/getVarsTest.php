<?php
namespace tests\res\presentation\requests\RwHttpRequest;
use mocks\presentation\requests\PopulatedRequest;

/**
 * @covers \vsc\presentation\requests\RwHttpRequest::getVars()
 */
class getVars extends \BaseUnitTest
{
	public function testGetVars() {
		$o = new PopulatedRequest();

		$existingTaintedVars = array(
			'module'	=> 'test',
			'cucu'		=> 'mucu',
			'height'	=> 143
		);
		$existingGetVars	= array('cucu' => 'pasare','ana' => 'are', 'mere' => '', 'test' => 123);
		$existingPostVars	= array('postone' => 'are', 'ana' => '');
		$existingCookieVars	= array('user' => 'asddsasdad234');

		$existingVars = array ();
		$varOrder = PopulatedRequest::getVarOrder();
		foreach ($varOrder as $sMethod) {
			switch ($sMethod) {
				case 'S':
					break;
				case 'C':
					$existingVars = array_merge ($existingVars, $existingCookieVars);
					break;
				case 'P':
					$existingVars = array_merge ($existingVars, $existingPostVars);
					break;
				case 'G':
					$existingVars = array_merge ($existingVars, $existingGetVars);
					break;
			}
		}

		$this->assertEquals(array_merge($existingTaintedVars, $existingVars), $o->getVars());
	}
}
