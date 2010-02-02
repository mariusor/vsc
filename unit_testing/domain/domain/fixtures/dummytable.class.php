<?php
usingPackage ('models/foo');
usingPackage ('models/foo/fields');

class dummyTable extends fooEntityA {
	protected $name = 'dummy';

	public function __construct () {
		$this->id 		= new vscFieldInteger('id');
		$this->id->setAutoIncrement (true);

		$this->payload 		= new vscFieldVarChar ('payload');
		$this->timestamp 	= new vscFieldDateTime ('ts');

		$this->setPayload(2); // this is used later in the testGetter - if you modify here, modify the fooEntityTest

		$this->setPrimaryKey ($this->id);
	}
}