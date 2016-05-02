<?php namespace tests\ReceitaFederal\SP;

class testHelpers extends \PHPUnit_Framework_TestCase
{

	/**
	 * Testa o retorno dos helpers
	 * @group receita-helper
	 * @return array
	 */
	public function testHelperReturn()
	{
		$rf = receitaFederal();

		$this->assertArrayHasKey('cookie', $rf, 'Invalid array return by helper');
	}
}