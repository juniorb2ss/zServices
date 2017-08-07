<?php

namespace tests\ReceitaFederal\AN;

use PHPUnit\Framework\TestCase;
use zServices\ReceitaFederal\Search;

class testGetParams extends TestCase
{
    /**
     * @group receita-request
     */
    public function testGetParamsArray()
    {
    	$search = (new Search)->service()->request();

    	$paramsRequest = $search->params();

    	$this->assertTrue(
	    		is_array($paramsRequest),
	    		'Params returned not is valid array'
	    );
    }
}