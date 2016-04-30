<?php

use zServices\Sintegra\Search;

class testGetParams extends PHPUnit_Framework_TestCase
{
    public function testGetParams()
    {
    	$search = (new Search)->service('SP');

    	$paramsRequest = $search->params();
    	
    	$this->assertTrue(
	    		is_array($paramsRequest), 
	    		'Params returned not is valid array'
	    );
    }
}