<?php

use zServices\Sintegra\Search;

class testInvalidSequenceRequest extends PHPUnit_Framework_TestCase
{
    /**
     * Testa a sequência de request da classe
     * @expectedException zServices\Sintegra\Exceptions\NoServiceCall
     * @expectedExceptionMessageRegExp #No request.*#
     */
    public function testService()
    {
    	$search = (new Search)->service('SP');

    	# $search->request(); // método não foi requisitado, porém é obrigatório para sequência de requisição

    	$search->cookie();
    }
}