<?php namespace tests\Sintegra\SP;

class testHelpers extends \PHPUnit_Framework_TestCase
{

	/**
	 * Testa o retorno dos helpers
	 * @group sintegra-helper
	 * @return array
	 */
	public function testHelperReturn()
	{
		$sintegra = sintegra();

		$this->assertArrayHasKey('cookie', $sintegra, 'Invalid array return by helper');
	}
}