<?php

use zServices\Sintegra\Search;

class testGetCaptcha extends PHPUnit_Framework_TestCase
{
    public function testGetCaptcha()
    {
    	$search = (new Search)->service('SP');

    	$captchaRequest = $search->captcha();

    	$this->assertTrue(
	    		is_string($captchaRequest), 
	    		'Captcha returned not is valid string'
	    );
    }
}