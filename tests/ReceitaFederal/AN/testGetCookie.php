<?php

namespace tests\ReceitaFederal\AN;

use PHPUnit\Framework\TestCase;
use zServices\ReceitaFederal\Search;

class testGetCookie extends TestCase
{
	/**
     * @group receita-request
     */
    public function testGetCookieString()
    {
    	$search = (new Search)->service()->request();

    	$cookieRequest = $search->cookie();

    	$this->assertTrue(
	    		is_string($cookieRequest), 
	    		'Cookie returned not is valid string'
	    );
    }
}