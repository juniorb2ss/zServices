<?php

namespace tests\Sintegra\SP;

use PHPUnit\Framework\TestCase;
use zServices\Sintegra\Search;

class testInvalidSequenceRequest extends TestCase
{
    /**
     * Testa a sequência de request da classe
     * @expectedException zServices\Miscellany\Exceptions\NoServiceCall
     * @expectedExceptionMessageRegExp #No request.*#
     * @group sintegra-request
     */
    public function testService()
    {
    	$search = (new Search)->service('SP');

    	# $search->request(); // método não foi requisitado, porém é obrigatório para sequência de requisição

    	$search->cookie();
    }
}