<?php

namespace zServices\Tests\ReceitaFederal\SP;

use zServices\Tests\TestCase;

class testHelpers extends TestCase
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