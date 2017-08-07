<?php

namespace zServices\Tests\Sintegra\SP;

use zServices\Tests\TestCase;
use zServices\Sintegra\Search;

class testGetCookie extends TestCase
{
	/**
     * @group sintegra-request
     */
    public function testGetCookieString()
    {
    	$search = (new Search)->service('SP')->request();

    	$cookieRequest = $search->cookie();

    	$this->assertTrue(
	    		is_string($cookieRequest), 
	    		'Cookie returned not is valid string'
	    );
    }
}