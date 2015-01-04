<?php
namespace tests\res\presentation\requests\RwHttpRequest;
use fixtures\presentation\requests\PopulatedRequest;

/**
 * @covers \vsc\presentation\requests\RwHttpRequest::getVars()
 */
class getVars extends \PHPUnit_Framework_TestCase
{
	public function testGetVars() {
		$o = new PopulatedRequest();

		$ExistingTaintedVars = array(
			'module'	=> 'test',
			'cucu'		=> 'mucu',
			'height'	=> 143
		);
		$ExistingGetVars	= array('cucu' => 'pasare','ana' => 'are', 'mere' => '', 'test' => 123);
		$ExistingPostVars	= array('postone' => 'are', 'ana' => '');
		$ExistingCookieVars	= array('user' => 'asddsasdad234');

		$ExistingVars = array ();
		$VarOrder = $o->getVarOrder();
		foreach ($VarOrder as $sMethod) {
			switch ($sMethod) {
				case 'S':
					break;
				case 'C':
					$ExistingVars = array_merge ($ExistingVars, $ExistingCookieVars);
					break;
				case 'P':
					$ExistingVars = array_merge ($ExistingVars, $ExistingPostVars);
					break;
				case 'G':
					$ExistingVars = array_merge ($ExistingVars, $ExistingGetVars);
					break;
			}
		}

		$this->assertEquals(array_merge($ExistingTaintedVars, $ExistingVars), $o->getVars());
	}
}
