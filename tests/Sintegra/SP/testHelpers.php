<?php

namespace tests\Sintegra\SP;

use PHPUnit\Framework\TestCase;

class testHelpers extends TestCase
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