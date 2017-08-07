<?php

namespace zServices\Tests\ReceitaFederal\AN;

use zServices\Tests\TestCase;
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