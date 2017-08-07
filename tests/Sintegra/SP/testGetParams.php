<?php

namespace tests\Sintegra\SP;

use PHPUnit\Framework\TestCase;
use zServices\Sintegra\Search;

class testGetParams extends TestCase
{
    /**
     * @group sintegra-request
     */
    public function testGetParamsArray()
    {
    	$search = (new Search)->service('SP')->request();

    	$paramsRequest = $search->params();

    	$this->assertTrue(
	    		is_array($paramsRequest),
	    		'Params returned not is valid array'
	    );
    }
}