<?php

use zServices\Sintegra\Search;

class testGetCookie extends PHPUnit_Framework_TestCase
{
    public function testGetCookie()
    {
    	$search = (new Search)->service('SP');

    	$cookieRequest = $search->cookie();

    	$this->assertTrue(
	    		is_string($cookieRequest), 
	    		'Cookie returned not is valid string'
	    );
    }
}